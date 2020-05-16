<?php
namespace App\Controller;


use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ModifConnexionController extends AbstractController
{
    protected $toto;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->toto = $encoder;
    }

    /**
     * @Route("/enregistrementUtilisateur", name="enregistrementUtilisateur")
     */
    public function newUtilisateur(){
        $user = new User();
        $user->setEmail('admin@gmail.com');
        // On encode le mot de passe "j_ai_la_banane" dans l'utilisateur
        $mdpEncode = $this->toto->encodePassword($user, "toto");
        $user->setPassword($mdpEncode);
        $user->setRoles(["ROLE_ADMIN"]);
        dump($user);
        /*die;*/
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
    }
}