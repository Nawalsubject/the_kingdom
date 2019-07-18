<?php

namespace App\Controller;

use App\Entity\FileCategory;
use App\Repository\DocumentRepository;
use App\Repository\FileCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/document")
 * Class DocumentController
 * @package App\Controller
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/folders", name="folders")
     * @param FileCategoryRepository $fileCategoryRepository
     * @return Response
     */
    public function index(FileCategoryRepository $fileCategoryRepository)
    {
        $folders = $fileCategoryRepository->findAll();

        return $this->render('document/index.html.twig', [
            'folders' => $folders,
        ]);
    }

    /**
     * @Route("/{id}/files", name="show_files_by_category")
     * @param DocumentRepository $documentRepository
     * @param FileCategory $fileCategory
     * @return Response
     */
    public function showByCategory(DocumentRepository $documentRepository, FileCategory $fileCategory)
    {
        $files = $documentRepository->findByFileCategory($fileCategory);

        return $this->render('document/showByCategory.html.twig', [
            'files' => $files,
        ]);
    }
}
