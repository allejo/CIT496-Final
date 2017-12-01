<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $loginEventRepo = $this->getDoctrine()->getRepository('AppBundle:LoginEvent');

        $successful_logins = null;
        $failed_logins = null;
        $login_attempts = null;

        if ($this->getUser() !== null) {
            $successful_logins = $loginEventRepo->countLoginAttempts($this->getUser());
            $failed_logins = $loginEventRepo->countLoginAttempts($this->getUser(), null, false);
            $login_attempts = $loginEventRepo->getLastFailedLogins($this->getUser(), 5);
        }

        return $this->render('default/index.html.twig', array(
            'logins' => array(
                'successful' => $successful_logins,
                'failed' => $failed_logins,
                'attempts' => $login_attempts,
            ),
        ));
    }
}
