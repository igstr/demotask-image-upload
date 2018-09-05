<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends Controller
{
    /**
     * @Route("/image/{id}/", name="image")
     */
    public function showAction(Request $request, $id)
    {
        $repo = $this->get('doctrine')->getRepository(Image::class);
        $image = $repo->find($id);
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
    public function createAction(Request $request, EntityManagerInterface $entityManager)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile */
            $file = $image->getFile();

            $filename = date('Ymd\THi-').$file->getClientOriginalName();
            // $filename = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to uploads directory
            $file->move(
                $this->getParameter('upload_dir'),
                $filename
            );

            /**
             * Updates the filename property to store the actual filename
             * instead of the file contents.
             */
            $image->setFile($filename);

            // TODO Create and set image slug
            $slug = $image->getTitle();
            $image->setSlug($slug);

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
