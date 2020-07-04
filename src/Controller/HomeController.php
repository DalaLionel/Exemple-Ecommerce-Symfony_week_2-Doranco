<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $repository, CategoryRepository $repo)
    {
        $categories=$repo->findAll();
        $result = $repository->findNewProducts();
        return $this->render('home/index.html.twig', [
            'new_products'=>$result,
            'categories'=>$categories]);
    }

    /**
     * @Route("/{id}/CategoryProducts",name="CategoryProducts")
     */
    public function showCategories(Category $category,$id)
    {
        $products= $category->getProducts();
        return $this->render('home/productsfromcategory.html.twig',[
            'category'=>$category,
            'produitscategorie'=>$products
        ]);
    }
}
