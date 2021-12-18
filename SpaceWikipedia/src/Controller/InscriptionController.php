<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FormulaireInscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ContainerJlfspmw\getFormulaireInscriptionTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder){
        $user = new User();

        $form = $this->createForm(FormulaireInscriptionType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('connexion');
        }

        return $this->render('Inscription/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
