<?php

namespace App\Controller;
use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    	if($request->isMethod('POST'))
    	{
    		$data = $request ->request -> all();
    		if($this->isCsrfTokenValid('event_key',$data['_token']))
    		{
    			$event = new Event;

    			$event->setTitle($data['title']);
    			$event->setDescription($data['description']);
    			$event->setDateEvent(new \DateTime());
    			$event->setImage("veqp");

    			$em->persist($event);
    			$em->flush(); 
    		}
    		return $this->redirectToRoute("home");

    	}
    	return $this->render("home/create.html.twig");
    }

}


