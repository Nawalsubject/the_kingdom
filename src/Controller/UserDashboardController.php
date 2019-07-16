<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserInformationType;
use App\Form\UserJobsType;
use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function index(JobRepository $jobRepository): Response
    {

        $user = $this->getUser();

        $buddy = $user->getBuddy();

        $godChildren = $user->getGodChildren();

        $jobs = $jobRepository->findByUserWithTrades($user->getId());

        dump($jobs);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'buddy' => $buddy,
            'jobs' => $jobs,
            'godChildren' => $godChildren,
        ]);
    }

    /**
     * @Route("/{addWhat}/listing", name="user_listing")
     * @param UserRepository $userRepository
     * @param string $addBuddy
     * @return Response
     */
    public function userListing(UserRepository $userRepository, string $addWhat): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/userListing.html.twig', [
            'users' => $users,
            'addWhat' => $addWhat,
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
     * @Route("/{id}/user-edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserInformationType::class, $user);
        $form->handleRequest($request);
        $oldPassword = $form->get('oldPassword')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ( empty($oldPassword) ) {
                $this->getDoctrine()->getManager()->flush();
                $user->setImageFile(null);

                $this->addFlash('success', 'Vos informations ont bien été modifiés.');
                return $this->redirectToRoute('user_dashboard');
            }
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
                $user->setPassword($newEncodedPassword);
                $this->getDoctrine()->getManager()->flush();
                $user->setImageFile(null);

                $this->addFlash('success', 'Vos informations ont bien été modifiés.');
                return $this->redirectToRoute('user_dashboard');
            }

            $form->addError(new FormError('Ancien mot de passe incorrect'));
        }

        return $this->render('user/editUserInformation.html.twig', [
            'user' => $user,
            'userInformationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/jobs-edition", name="user_jobs_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function editJobs(Request $request, User $user): Response
    {
        $form = $this->createForm(UserJobsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success' , 'Vos métiers ont bien été modifés.');
            return $this->redirectToRoute('user_dashboard');
        }

        return $this->render('user/editUserJobs.html.twig', [
            'user' => $user,
            'jobsForm' => $form->createView(),
        ]);
    }

}
