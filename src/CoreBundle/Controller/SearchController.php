<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/search")
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
            $a_result->content = (property_exists($find, 'content')) ? $find->getContent() : null;
            $a_result->tag = (property_exists($find, 'tag')) ? $find->getTag() : null;
            $a_result->name = (property_exists($find, 'name')) ? $find->getName() : null;
            $result_array[] = $a_result;            
        }        

        $res = new Response(json_encode($result_array));
        $res->headers->set('Content-Type', 'application/json');

        return $res;
    }
}