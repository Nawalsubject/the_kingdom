<?php

namespace App\Controller;

use App\Repository\DocumentRepository;
use App\Repository\FileCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    /**
     * @Route("/document", name="document")
     */
    public function index(FileCategoryRepository $fileCategoryRepository)
    {
        $folders = $fileCategoryRepository->findAll();

        return $this->render('document/index.html.twig', [
            'folders' => $folders,
        ]);
    }
}
