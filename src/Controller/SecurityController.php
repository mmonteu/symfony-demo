<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\User;
use App\Form\RegistrationType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager)
    {
    	$user = new User();

    	$form = $this->createForm(RegistrationType::class, $user);

		$form->handleRequest($request);

        	if($form->isSubmitted() && $form->isValid()) {
            	$manager->persist($user);
            	$manager->flush();

			return $this->redirectToRoute('security_login');
        	}

    	return $this->render('security/registration.html.twig', ['form' => $form->createView()] );

    }

}
