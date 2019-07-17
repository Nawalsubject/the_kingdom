<?php

namespace App\Controller;

use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    /**
     * @Route("/document", name="document")
     */
    public function index(DocumentRepository $documentRepository)
    {
        $documents = $documentRepository->findAll();

        return $this->render('document/index.html.twig', [
            'documents' => $documents,
        ]);
    }
}
