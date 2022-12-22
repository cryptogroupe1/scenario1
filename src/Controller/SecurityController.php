<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use function PHPUnit\Framework\equalTo;

class SecurityController extends AbstractController
{

    public function __construct(private ManagerRegistry $managerRegistry){}

    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route('/forget', name: 'user.forget')]
    public function changeLoginAndpassword(Request $request){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove("password");
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $message = 'Un email a été envoyé à votre adreese; veillez vous rendre dans la boite de reception pour créer de nouveaux identifiants !';
            self::sendMail('echo "Cliquez sur le lien pour changer vos informations d\'identifications : http://localhost:8000/updateLoginAndPassword" | mail -s "Informations d\'identification" '.$user->getUserIdentifier());
            return $this->render('security/changeLoginAndPassword.html.twig', ['message' => $message]);
        }
        else{
            return $this->render('security/changeLoginAndPassword.html.twig', ['form'=>$form->createView()]);
        }
    }

    /**Utilisation d'un serveur SMPT (postfix) configuré en localhost et executable sur le shell pour envoyé un mail vers tout les domaines
     * @param $mail : ligne de commande exécutée sur le terminal
     * @return void
     */
    public static function sendMail($mail){
        exec($mail);
    }
}
