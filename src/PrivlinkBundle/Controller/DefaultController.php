<?php

namespace PrivlinkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PrivlinkBundle\Entity\privlink;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use PrivlinkBundle\Form\privlinkType;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('PrivlinkBundle:Default:index.html.twig');
    }

    /**
     * @Route("/info/about/")
     */
    public function aboutAction()
    {
        return $this->render('PrivlinkBundle:info:about.html.twig');
    }

    /**
     * @Route("/info/faq/")
     */
    public function faqAction()
    {
        return $this->render('PrivlinkBundle:info:faq.html.twig');
    }

    /**
     * @Route("/save/{hash}")
     */
    public function saveAction($hash)
    {
        return $this->render('PrivlinkBundle:info:save.html.twig', array('hash'=>$hash));
    }
}
