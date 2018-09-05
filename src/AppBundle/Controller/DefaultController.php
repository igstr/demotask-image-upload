<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $package = new PathPackage('/uploads', new EmptyVersionStrategy());
        $repo = $this->get('doctrine')->getRepository(Image::class);
        $images = $repo->findAll();

        if (!empty($images)) {
            foreach ($images as $image) {
                $image->page_url = $this->generateUrl('image', ['id' => $image->getId()]);
                $image->src = $package->getUrl($image->getFile());
            }
        }

        return $this->render('default/index.html.twig', [
            'html_title' => 'Demo Task Image Uploader',
            'title' => 'Demo Task Image Uploader',
            'form' => $form->createView(),
            'images' => $images,
        ]);
    }
}