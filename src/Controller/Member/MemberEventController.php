<?php

namespace App\Controller\Member;

use App\Entity\Event;
use App\Entity\Member;
use App\Service\Controller\AbstractAppController;
use App\Service\Alert\Alert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberEventController extends AbstractAppController
{
    public function __construct(
        private readonly int $orderAmountAlertLevel,
    ) {}

    #[Route('/members/{id}/notifications', name: 'member_events')]
    public function setMemberEvents(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $member = $manager->getRepository(Member::class)->find($id);
        $events = $manager->getRepository(Event::class)->findAllOrdered();

        if ($request->isMethod('POST')) {
            foreach ($events as $event) {
                ($request->request->has(str_replace('.', '_', $event->getId()))) ?
                    $member->addEvent($event) : $member->removeEvent($event);
            }

            if ($request->request->has('amount-alert')) {
                $member->setAmountAlert(true);
                $member->setAmountLevel($request->request->get('amount-level'));
            } else {
                $member->setAmountAlert(false);
            }

            $manager->flush();

            $this->dispatchAlert(Alert::INFO, 'Vos alertes ont été modifiées avec succès');

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'member/events.html.twig',
            [
                'memberEvents' => $member->getEvents(),
                'loggedMember' => $member,
                'events' => $events,
                'orderAmountAlertLevel' => $this->orderAmountAlertLevel,
            ]
        );
    }
}
