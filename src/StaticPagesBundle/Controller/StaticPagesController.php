<?php

namespace StaticPagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StaticPagesController extends Controller
{   	
    public function aboutAction()
    {
        return $this->render('StaticPagesBundle:Default:about.html.twig');
    }
}
