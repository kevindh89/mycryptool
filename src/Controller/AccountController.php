<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Account;
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
     * @Route("/setup", name="setup")
     */
    public function setup(Request $request)
    {
        if ($request->isMethod('POST')) {
            $startCapital = $request->request->get('start-capital');

            $account = new Account(getenv('GDAX_API_KEY'), (float) $startCapital);
            $account->setStartCapital((float) $startCapital);
            $this->getDoctrine()->getManager()->persist($account);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('dashboard'));
        }

        return $this->render('account/setup.html.twig');
    }

    /**
     * @Route("/update", name="update")
     */
    public function update(Request $request): Response
    {
        $account = $this
            ->getDoctrine()
            ->getRepository('App\Entity\Account')
            ->find(getenv('GDAX_API_KEY'));

        if ($request->isMethod('GET')) {
            return $this->render('account/update.html.twig', [
                'account' => $account,
            ]);
        }

        $startCapital = $request->request->get('start-capital');
        if (!$account) {
            $account = new Account(getenv('GDAX_API_KEY'), (float) $startCapital);
        }

        $account->setStartCapital((float) $startCapital);
        $this->getDoctrine()->getManager()->persist($account);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('dashboard'));
    }
}
