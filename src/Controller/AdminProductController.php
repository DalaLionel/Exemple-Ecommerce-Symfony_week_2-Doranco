<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ConfirmDeletionFormType;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Autoriser l'accès aux admins sur toutes les routes de ce contrôleur
 * @IsGranted("ROLE_ADMIN")
 *
 * Spécifier un préfice d'URI et de nom de route
 * @Route("/admin/product", name="admin_product_")
*/
class AdminProductController extends AbstractController
{
    /**
     * méthode pour la liste des produits
     * comme on a déjà défini le début de la route et du nom on peut juste ajouter ce qu'il manque
     * en combinant l'annotation de la classe et celle de la méthode on obtient
     * /admin/products et name="admin_product_list"
     * @Route("s", name="list")
     */
    public function list(ProductRepository $repository)
    {
        $produits=$repository->findAll();
        return $this->render('admin_product/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @Route("/new", name="add")
     */
    public function add(EntityManagerInterface $em,Request $request)
    {
        $form=$this->createForm(ProductFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $new_product = $form->getData();
            $em->persist($new_product);
            $em->flush();

            $this->addFlash('success','Le produit a été enregistré');
            return $this->redirectToRoute('admin_product_list');
        }
        return $this->render('admin_product/admin_add.html.twig', ['Formulaire_new'=>$form->createView()]);
    }

    /**
     * @Route("/{id}/edit",name="edit")
     */
    public function edit(Product $product, EntityManagerInterface $em,Request $request)
    {
        $form=$this->createForm(ProductFormType::class,$product);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le produit a été modifié');
            return $this->redirectToRoute('admin_product_list');
        }
        return $this->render('admin_product/edit.html.twig', [
            'productamodif'=>$product,
            'Formulaire_edit'=>$form->createView()]);
    }

    /**
     * @Route("{id}/delete", name="delete")
     */
    public function delete(Product $product, Request $request, EntityManagerInterface $em)
    {
        $form=$this->createForm(ConfirmDeletionFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid())
        {
            $em->remove($product);
            $em->flush();
            $this->addFlash('success', 'Le produit est parti aux oubliettes');
            return $this->redirectToRoute('admin_product_list');
        }
        return $this->render('admin_product/delete.html.twig', [
            'product'=>$product,
            'deletion_form' => $form->createView()
        ]);
    }
}
