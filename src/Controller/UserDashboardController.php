<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
    public function index()
    {
        $user = $this->getUser();

        $buddy = $user->getBuddy();

        $godChildren = $user->getGodChildren();

        return $this->render('user_dashboard/index.html.twig', [
            'user' => $user,
            'buddy' => $buddy,
            'godChildren' => $godChildren,
        ]);
    }
}
