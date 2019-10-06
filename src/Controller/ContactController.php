<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Contact;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ObjectManager $manager)
    {
    	$contact = new Contact;

        $form = $this->createFormBuilder($contact)
                     ->add('name', TextType::class, [ 'attr' => [ 'placeholder' => "Votre nom", 'class' => 'form-control' ]])
                     ->add('mail', EmailType::class, [ 'attr' => [ 'placeholder' => "mail@gmail.com", 'class' => 'form-control' ]])
                     ->add('object', TextType::class, [ 'attr' => [ 'placeholder' => "Objet du message", 'class' => 'form-control' ]])
                     ->add('content', TextareaType::class, [ 'attr' => [ 'placeholder' => "Votre message ici", 'class' => 'form-control' ]])
                     ->getForm();

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
            		$manager->persist($contact);
            		$manager->flush();
        	}

        return $this->render('contact/contact.html.twig', ['formContact' => $form->createView()]);
    }
}
