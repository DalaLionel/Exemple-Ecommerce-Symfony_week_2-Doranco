<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/profile", name="account")
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid())
        {
            //il n'est pas nécessaire d'appeler persist pour modifier
            //des entités, il sert plutôt à en ajouter de nouvelles
            //par contre on doit appeler flush pour envoyer en bdd

            $em->flush();
            $this->addFlash('success','Votre profil a bien été mis à jour');

        }
        return $this->render('account/profile.html.twig',[
            'ChangeMailForm' => $form->createView()])
            ;
    }
}
