<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EntityBundle\Entity\Book;
use EntityBundle\Entity\Chapter;
use Symfony\Component\HttpFoundation\Request;


/**
* @Route("/browse")
*/
class BrowseController extends Controller
{
    /**
     * Lists all books
     * @Route("/", name="BookIndex")
     */
    public function bookAction()
    {
        return $this->render('CoreBundle:Browse:book.html.twig', array(
            // ...
        ));
    }

    /**
     * Lists all chapters for a given book
     * @Route("/{book}")
     */
    public function chaptersAction(Request $req)
    {


        return $this->render('CoreBundle:Browse:chapter.html.twig', array(
            // ...
        ));
    }

    /**     
     * @Route("/{book}/{chapter}")
     */
    public function singleChapterAction(Request $req)
    {
        return $this->render('CoreBundle:Browse:single.html.twig', array(
            // ...
        ));
    }
}
