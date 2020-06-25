<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_list")
     */
    public function List(ProductRepository $repo)
    {
        $result = $repo->findAll();
        return $this->render('product/index.html.twig', [
            'h1_page_en_cours' => 'Liste des produits',
            'titre_page'=>'Liste',
            'products'=>$result
        ]);
    }

    /*
     * public function index(ProductRepository $repository)
     * {
     * $product_list=$repository->findAll();
     * return $this->render('product/index,[
     * 'product_list'=>$product_list
     * ]);
     * }
     */

    /*
      @Route("/product/{id}", name="product_show")

    public function Show($id, ProductRepository $repository)
    {
        $item=$repository->findBy(['id'=>$id]);
        return $this->render('product/show.html.twig', [
            'h1_page_en_cours' => "Le produit.$id",
            'titre_page'=>'Focus Produit',
            'item'=>$item
        ]);
    }
    */

    /**
     * @Route("/product/{id}", name="product_show")
     */
      public function show(Product $product,$id)
      {
        return $this->render('product/show.html.twig',[
        'product'=>$product,
        'id'=>$id
        ]);
      }


}
