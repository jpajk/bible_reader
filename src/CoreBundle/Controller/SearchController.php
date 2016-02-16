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
    	$verse = $this->getDoctrine()
                   ->getRepository('EntityBundle:Verse')
                   ->find(1);
        
    	//$result = $finder->find('1*');

    	dump($verse->getTag());

        return new Response('');
    }
}
