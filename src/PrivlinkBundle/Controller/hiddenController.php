<?php

namespace PrivlinkBundle\Controller;

use PrivlinkBundle\Entity\privlink;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hidden controller.
 *
 * @Route("hidden")
 */

class hiddenController extends Controller
{

    public function indexAction($hash)
    {

        $em = $this->getDoctrine()->getManager();

        $note = $em->createQueryBuilder('privlink')
            ->select('privlink')
            ->from('PrivlinkBundle:privlink','privlink')
            ->andWhere('privlink.hash IN (:hash)')
            ->setParameter('hash', $hash)
            ->getQuery();
        $text = $note->getResult();

        return $this->render('PrivlinkBundle:privlink:hidden.html.twig', array(
            'privlinks' => $text,
        ));



    }


}



?>