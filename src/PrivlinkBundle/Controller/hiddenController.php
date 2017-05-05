<?php

namespace PrivlinkBundle\Controller;

use PrivlinkBundle\Entity\privlink;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Null;

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
        $text = $note->getSingleResult();

        $configuration = $text->getConfiguration();

            if ($configuration) {
                $em->createQueryBuilder('privlink')
                    ->update('PrivlinkBundle:privlink', 'privlink')
                    ->set('privlink.configuration', '?1')
                    ->setParameter(1, false)
                    ->andwhere('privlink.hash IN (:hash)')
                    ->setParameter('hash', $hash)
                    ->getQuery()->getSingleScalarResult();

                return $this->render('PrivlinkBundle:privlink:hidden.html.twig', array(
                    'privlink' => $text,
                ));
            } else{
                return $this->render('PrivlinkBundle:privlink:empty_page.html.twig');
            }

        }



}



