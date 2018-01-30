<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        return new Response('MyCryptool is working!');
    }
}