<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use AppBundle\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends Controller
{
    /**
     * @Route("/image/{id}/", name="image", requirements={"id"="\d+"})
     */
    public function showAction(Request $request, $id)
    {
        $repo = $this->get('doctrine')->getRepository(Image::class);
        $image = $repo->find($id);

        if (empty($image)) {
            $msg = sprintf('Image with id "%s" cannot be found', $id);
            throw new NotFoundHttpException($msg);
        }

        $image->src = '/uploads/'.$image->getFile();

        return $this->render('default/page_image.html.twig', [
            'html_title' => 'Demo Task Image Uploader',
            'title' => 'Demo Task Image Uploader',
            'image' => $image,
        ]);
    }

    /**
     * @Route("/image/", name="create_image", methods={"POST"})
     */
    public function createAction(Request $request, EntityManagerInterface $entityManager, UploadService $uploadService)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile */
            $file = $image->getFile();

            $filename = $uploadService->upload($file);

            // Updates the filename property to store the actual filename
            // instead of the file contents.
            $image->setFile($filename);

            $entityManager->persist($image);
            $entityManager->flush();
        } else {
            // TODO return error response
            return new Response('NOT OK', 500);
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
