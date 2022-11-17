<?php

namespace App\Controller\Help;

use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/help/order', name: 'help_order')]
class HelpOrderController extends AbstractAppController
{
    #[Route('/new', name: '_new')]
    public function newOrder(): Response
    {
        return $this->render('help/order/new_order.html.twig');
    }
}
