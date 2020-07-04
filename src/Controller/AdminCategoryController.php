<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Form\ConfirmDeletionFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/category",name="_admin_category_")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     *
     */
    public function list(CategoryRepository $repository)
    {
        $category = $repository->findAll();
        return $this->render('admin_category/list.html.twig', [
            'categories' => $category
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(CategoryFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('_admin_category_list');
        }

        return $this->render('admin_category/add.html.twig', [
            "Formulaire" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(EntityManagerInterface $em, Request $request, Category $category)
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('_admin_category_list');
        }

        return $this->render('admin_category/edit.html.twig', [
            'Formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete",name="delete")
     */
    public function delete(Category $category, EntityManagerInterface $em, Request $request)
    {
        $form =$this->createForm(ConfirmDeletionFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->remove($category);
            $em->flush();
            return $this->redirectToRoute('_admin_category_list');
        }

        return $this->render('admin_category/delete.html.twig',[
            'category'=>$category,
            'Formulaire_delete'=>$form->createView()
        ]);
    }

}
