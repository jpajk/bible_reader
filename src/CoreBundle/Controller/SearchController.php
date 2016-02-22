<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/", name="Home")
     */
    public function searchAction()
    {
    	return $this->render('CoreBundle:Search:search.html.twig');
    }

    /**
     * @Route("/search/query") 
     */
    public function queryAction(Request $req)
    {
        $finder = $this->container->get('fos_elastica.finder.bible');
        $query = $req->query->get('q');

        $result = $finder->find($query . '*');
        $result_array = [];

        foreach ($result as $key => &$find) 
        {
            $a_result = new \stdClass();
            $a_result->id = $find->getId();
            $a_result->content = $find->getContent();
            $a_result->tag = $find->getTag();
            $a_result->shortname = $find->getBookShortname();
            $a_result->chapter = $find->getChapterNumber();
            $result_array[] = $a_result;            
        }        

        $res = new Response(json_encode($result_array));
        $res->headers->set('Content-Type', 'application/json');

        return $res;
    }
}