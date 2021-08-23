<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberEventController extends AbstractController
{
    #[Route('/members/{id}/notifications', name: 'member_events')]
    public function setMemberEvents(int $id, Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $member = $manager->getRepository(Member::class)->find($id);
        $events = $manager->getRepository(Event::class)->findAllOrdered();

        if ($request->isMethod('POST')) {
            foreach ($events as $event) {
                ($request->request->has($event->getId())) ?
                    $member->addEvent($event) : $member->removeEvent($event);
            }

            $manager->flush();

            $this->addFlash('info', 'Vos alertes ont été modifiées avec succès');

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'member/events.html.twig',
            [
                'memberEvents' => $member->getEvents(),
                'events' => $events,
            ]
        );
    }
}
