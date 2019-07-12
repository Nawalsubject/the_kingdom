<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 * Class UserDashboardController
 * @package App\Controller
 */
class UserDashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="user_dashboard")
     */
    public function index()
    {
        $user = $this->getUser();

        $buddy = $user->getBuddy();

        $godChildren = $user->getGodChildren();

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'buddy' => $buddy,
            'godChildren' => $godChildren,
        ]);
    }

    /**
     * @Route("/listing", name="user_listing")
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userListing(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('user/userListing.html.twig', [
            'users' => $users,
        ]);
    }
}
