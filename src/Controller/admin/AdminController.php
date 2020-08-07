<?php


namespace App\Controller\admin;


use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/home", name="admin.product.index")
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository){
        $product = $repository->findBy(array(),array(
            "created_at" => "DESC",
            "updated_at"=>"ASC",
            "id" => "ASC"
        ));
        dump($product);
        return $this->render("admin/index.html.twig",[
           "products" => $product
        ]);
    }

    /**
     * @Route("/admin/product/edit/{id}", name="admin.product.edit", methods="GET|POST")
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request,Product $product):Response
    {
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute("admin.product.index");
        }
        return $this->render("admin/edit.html.twig",[
            "product" => $product,
            "form"=>$form->createView()]);
    }

    /**
     * @Route("/admin/product/new", name="admin.product.new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request):Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return $this->redirectToRoute("admin.product.index");
        }
        return $this->render("admin/new.html.twig",[
            "form" => $form->createView()
        ]);
    }

}