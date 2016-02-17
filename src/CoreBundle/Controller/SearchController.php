<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * @Route("/search")
     */
    public function searchAction()
    {
    	return $this->render('CoreBundle:Search:search.html.twig');
    }
}

/*
$verse = $this->getDoctrine()
                   ->getRepository('EntityBundle:Verse')
                   ->find(1);
        
        //$result = $finder->find('1*');

        dump($verse->getTag());

        return new Response('');
 */