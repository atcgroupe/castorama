<?php

namespace App\Controller\Order;

use App\Entity\Order;
use App\Entity\User;
use App\Form\OrderSendType;
use App\Form\OrderUpdateDeliveryType;
use App\Form\OrderRegistrationType;
use App\Form\OrderInfoType;
use App\Form\OrderUpdateStatusType;
use App\Repository\OrderRepository;
use App\Security\Voter\OrderVoter;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use App\Service\Event\OrderEvent;
use App\Service\Order\OrderHelper;
use App\Service\Order\OrderSignCollectionHelper;
use App\Service\Order\OrderSignHelper;
use App\Service\Order\OrderSignResumeHelper;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders', name: 'orders')]
class OrderController extends AbstractAppController
{
    private const UPDATE_ELEMENT_STATUS = 'status';
    private const UPDATE_ELEMENT_DELIVERY = 'delivery';
    private const UPDATE_ELEMENT_INFO = 'info';

    /**
     * @var ObjectManager
     */
    private ObjectManager $manager;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly OrderRepository $orderRepository,
        private readonly OrderSignResumeHelper $resumeHelper,
        private readonly OrderSignHelper $signHelper,
        private readonly EventDispatcherInterface $eventDispatcher,
        ManagerRegistry $doctrine,
    ) {
        $this->manager = $doctrine->getManager();
    }

    #[Route('/create', name: '_create')]
    public function create(Request $request): Response
    {
        $order = new Order();
        $hasForm = $this->isGranted('ROLE_CUSTOMER_ADMIN');

        if ($hasForm) {
            $form = $this->createForm(OrderRegistrationType::class, $order);
            $form->handleRequest($request);
        }

        if (
            !$hasForm ||
            (
                $form->isSubmitted() && $form->isValid()
            )
        ) {
            $this->manager->persist($order);
            $this->manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                'Votre commande est créée. Vous pouvez maintenant ajouter des panneaux!'
            );

            return $this->redirectToRoute('orders_view', ['id' => $order->getId()]);
        }

        return $this->render(
            'order/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/{id}/view', name: '_view')]
    public function view(int $id, OrderSignCollectionHelper $collectionHelper, Request $request): Response
    {
        $order = $this->orderRepository->findOneWithRelations($id);
        $resume = $this->resumeHelper->getResume($order);
        $signs = $collectionHelper->getCollections($order);

        $referer = $request->headers->get('referer');
        if (str_contains($referer, '/orders/list')) {
            $this->requestStack->getSession()->set('referer', $referer);
        }

        return $this->render(
            'order/view.html.twig',
            [
                'order' => $order,
                'signs' => $signs,
                'resume' => $resume
            ]
        );
    }

    #[Route(
        '/{id}/update/{element}',
        name: '_update',
        requirements: ['element' => 'status|delivery|info'],
    )]
    public function update(int $id, string $element, Request $request, OrderHelper $orderHelper): Response
    {
        $order = $this->orderRepository->findOneWithRelations($id);

        switch ($element) {
            case self::UPDATE_ELEMENT_STATUS:
                $form = $this->createForm(OrderUpdateStatusType::class, $order);
                $this->denyAccessUnlessGranted(User::ROLE_COMPANY_ADMIN);
                break;
            case self::UPDATE_ELEMENT_DELIVERY:
                $form = $this->createForm(OrderUpdateDeliveryType::class, $order);
                $this->denyAccessUnlessGranted(User::ROLE_COMPANY_ADMIN);
                break;
            case self::UPDATE_ELEMENT_INFO:
                $form = $this->createForm(OrderInfoType::class, $order);
                $this->denyAccessUnlessGranted(OrderVoter::UPDATE_INFO, $order);
                break;
            default:
                $this->dispatchAlert(Alert::WARNING, 'Un problème est survenu lors de la modification');

                return $this->redirectToRoute('orders_view', ['id' => $id]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($element === self::UPDATE_ELEMENT_INFO) {
                $orderHelper->updateLastUpdateTime($order);
            }

            $this->manager->flush();

            if ($element === self::UPDATE_ELEMENT_STATUS) {
                $this->eventDispatcher->dispatch(new OrderEvent($order), OrderEvent::STATUS_CHANGED);
            };

            $this->dispatchAlert(Alert::INFO, 'Modifications enregistrées');

            return $this->redirectToRoute('orders_view', ['id' => $id]);
        }

        return $this->render(
            'order/update.html.twig',
            [
                'form' => $form->createView(),
                'order' => $order
            ]
        );
    }

    #[Route('/{id}/delete', name: '_delete')]
    public function delete(int $id, Request $request): Response
    {
        $order = $this->orderRepository->findOneWithRelations($id);

        $this->denyAccessUnlessGranted(OrderVoter::DELETE, $order);

        if ($request->isMethod('POST')) {
            $this->signHelper->removeAll($order);
            $this->manager->remove($order);
            $this->manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                sprintf('la commande n°%s a été supprimée avec succès.', $id)
            );

            return new RedirectResponse($this->requestStack->getSession()->get('referer'));
        }

        return $this->render(
            'order/delete.html.twig',
            [
                'order' => $order
            ]
        );
    }

    #[Route('/{id}/send', name: '_send')]
    public function send(int $id, Request $request): Response
    {
        $order = $this->orderRepository->findOneWithRelations($id);
        $resume = $this->resumeHelper->getResume($order);
        $form = $this->createForm(OrderSendType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventDispatcher->dispatch(new OrderEvent($order), OrderEvent::SEND);

            $this->manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'La commande a été envoyée avec succès.');
            $this->eventDispatcher->dispatch(new OrderEvent($order), OrderEvent::STATUS_CHANGED);

            return $this->redirectToRoute('orders_view', ['id' => $id]);
        }

        return $this->render(
            'order/send.html.twig',
            [
                'order' => $order,
                'resume' => $resume,
                'form' => $form->createView(),
            ]
        );
    }
}
