<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	private $em;
	public function __construct(EntityManagerInterface $em)
	{
		$this->em=$em;
	}
    #[Route('/', name: 'home')]
    public function index():Response
    {
    	
    	$date = new \DateTime('@'.strtotime('now'));
    	$event = new Event;
    	$event ->setTitle('Le deuxieme cadeau');
    	$event ->setDescription("En effet, le grand roi a tous fais");
    	$event ->setDateEvent($date);
   		$event ->setImage("chemin de l'image");
   		//dd($event);

   		$this ->em ->persist($event);
   		$this ->em ->flush();

        return $this->render("home/home.html.twig");
    }
}


