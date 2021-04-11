<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\createFormBuilder;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EventRepository $repo):Response
    {
    	
        return $this->render("home/home.html.twig",['event'=>$repo->findAll()]);
    }
    #[Route('/event/create', name: 'create')]
    public function create(Request $request,EntityManagerInterface $em)
    {
    	$form = $this->createFormBuilder()
    		->add('title')
    		->add('description',TextareaType::class)
    		->add('date',DateTimeType::class)
    		->add('submit',SubmitType::class)
    		->getForm()
    	;

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form -> isValid())
    	{
    		$data = $form -> getData();

    		$event = new Event;
    		$event->setTitle($data['title']);
    		$event->setDescription($data['description']);
    		$event->setDateEvent($data['date']);
    		$event->setImage("irzoksio");

    		$em ->persist($event);
    		$em->flush();

    		return $this->redirectToRoute('home');
    	}
    	return $this->render("home/create.html.twig",['form'=>$form->createView()]);
    }

}


