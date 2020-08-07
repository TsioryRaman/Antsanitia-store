<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/product", name="product")
     * @param Request $request
     * @param PaginatorInterface $pagination
     * @return Response
     */
    public function index(Request $request,PaginatorInterface $pagination):Response
    {
        $paginator = $pagination->paginate($this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),8
            );
        $product = $this->repository->getLastProduct();
        return $this->render('product/index.html.twig', [
            'products' => $product,
            'paginatorProduct' => $paginator
        ]);
    }
}
