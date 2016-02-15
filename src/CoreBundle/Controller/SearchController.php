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
    	$finder = $this->container->get('fos_elastica.finder.bible.book');

    	$result = $finder->find('g*');

    	dump($result);

        return new Response('');
    }
}
