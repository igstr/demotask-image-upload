<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use AppBundle\Service\PaginateService as Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /** @var int Items per page */
    private $limit = 9;

    /** @var Paginator */
    private $paginator;

    /**
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->listAction($request);
    }

    /**
     * @Route("/images/{page}/", name="list_images", requirements={"page"="\d+"})
     */
    public function listAction(Request $request, $page = 1)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $repo = $this->get('doctrine')->getRepository(Image::class);
        $query = $repo->getAllInOrder('DESC');
        $paginator = $this->paginator->paginate($query, $this->limit, $page);
        $pageCount = $this->paginator->countPages($paginator, $this->limit);
        $images = $paginator->getIterator();

        $package = new PathPackage('/uploads', new EmptyVersionStrategy());

        if ($images->current()) {
            foreach ($images as $image) {
                $image->page_url = $this->generateUrl('image', ['id' => $image->getId()]);
                $image->src = $package->getUrl($image->getFile());
            }
        }

        return $this->render('default/index.html.twig', [
            'html_title'  => 'Demo Task - Image Uploader',
            'title'       => 'Demo Task - Image Uploader',
            'form'        => $form->createView(),
            'images'      => $images,
            'page'        => $page,
            'page_count'  => $pageCount,
            'route_pages' => 'list_images',
        ]);
    }
}