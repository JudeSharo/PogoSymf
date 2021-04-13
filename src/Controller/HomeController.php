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
    	$event = new Event;
    	$form = $this->createFormBuilder($event)
    		->add('title',NULL,['attr'=>['autofocus' => true]])
    		->add('description',TextareaType::class,['attr'=>['rows'=> 10,'cols'=>60]])
    		->add('dateEvent',DateTimeType::class,['label'=>'Date/time'])
    		->getForm()
    	;

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form -> isValid())
    	{
    		$event->setImage("pogo4");

    		$em ->persist($event);
    		$em->flush();

    		return $this->redirectToRoute('show',['id'=> $event->getId()]);
    	}
    	return $this->render("home/create.html.twig",['form'=>$form->createView()]);
    }
    #[Route('/event/{id<[0-9]+>}', name: 'show')]

    public function show(Event $event):Response
    {
    	
    	return $this->render('home/show.html.twig',compact('event'));
    }
}


