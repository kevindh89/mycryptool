<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account", name="account_")
 */
class AccountController extends Controller
{
    /**
     * @Route("/update", name="update")
     */
    public function update(Request $request): Response
    {
        if ($request->isMethod('GET')) {
            return $this->render('account/update.html.twig');
        }

        $startCapital = $request->request->get('start-capital');
        $request->getSession()->set('startCapital', $startCapital);

        return $this->redirect($this->generateUrl('dashboard'));
    }
}
