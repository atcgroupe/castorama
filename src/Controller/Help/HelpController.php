<?php

namespace App\Controller\Help;

use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractAppController
{
    #[Route('/help', name: 'help')]
    public function home(): Response
    {
        return $this->render('help/home.html.twig');
    }
}
