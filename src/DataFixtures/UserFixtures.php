<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**@var UserPasswordEncoderInterface*/
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        //création de 10 utilisateurs classiques
        for($i=0;$i<10;$i++)
        {
            $user=new User();

            //création du hash du mdp
            $hash=$this->passwordEncoder->encodePassword($user, 'user'.$i);

            $user
                ->setEmail('user'.$i.'@mail.org')
                //on a besoin d'un service pour bien crypter le mot de passe mais on n'a pas accès
                //à l'autowiring ici, on n'est pas dans un contrôleur. On doit donc passer par le constructeur. En général le constructeur peut
                //toujours avoir accès à l'autowiring même si on n'est pas dans un contrôleur
                ->setPassword($hash)
                ;
            $manager->persist($user);
        }

        for($i=0;$i<3;$i++)
        {
            $admin = new User();
            //création du hash du mdp
            $hash=$this->passwordEncoder->encodePassword($admin, 'admin'.$i);
            $admin
                ->setEmail('admin'.$i.'@mail.com')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($hash)
            ;
            $manager->persist($admin);
        }
        $manager->flush();
    }

    //Création de 3 administrateurs
    //email : admin0@mail.com
    //mdp: admin0
    //roles:ROLE_ADMIN

}
