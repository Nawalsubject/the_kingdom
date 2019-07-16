<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserInformationType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(): Response
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
    public function userListing(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/userListing.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}/add-buddy", name="add_buddy")
     * @param User $buddy
     * @return Response
     */
    public function addBuddy(User $buddy): Response
    {
        $user = $this->getUser();

        if ($user->getBuddy()) {
            $this->addFlash('danger', 'Vous avez déjà un parrain');
            return $this->redirectToRoute('user_listing');
        }

        $user->setBuddy($buddy);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre parrain vous a bien été affecté');

        return $this->redirectToRoute('user_dashboard');
    }

    /**
     * @Route("/{id}/add-godchild", name="add_godchild")
     * @param User $godchild
     * @return Response
     */
    public function addGodchild(User $godchild): Response
    {
        $user = $this->getUser();

        $user->addGodchild($godchild);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre filleul vous a bien été affecté');

        return $this->redirectToRoute('user_dashboard');
    }

    /**
     * @Route("/edition", name="account_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserInformationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vos informations ont bien été modifiées.');
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit_account.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}
