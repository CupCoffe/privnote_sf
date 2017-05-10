<?php

namespace PrivlinkBundle\Controller;

use MongoDB\BSON\Timestamp;
use PrivlinkBundle\Entity\privlink;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
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
            ->from('PrivlinkBundle:privlink', 'privlink')
            ->andWhere('privlink.hash IN (:hash)')
            ->setParameter('hash', $hash)
            ->getQuery();
        $text = $note->getSingleResult();

        //get value from database
        $configuration = $text->getConfiguration();
        //get today's datetime
        $nowDate = new \DateTime('now');
        //get value endDate from database
        $endDate = $text->getEndDate();

            if ($configuration) {
                if ($nowDate < $endDate ) {
                    //Returns the difference between two DateTime objects
                    $diff=date_diff($nowDate,$endDate);
                    echo $diff->format("%d днів %h годин %i хвилин %s секунд");

                    return $this->render('PrivlinkBundle:privlink:hidden_time.html.twig', array(
                        'privlink' => $text,
                    ));
                } else if ($endDate == NULL) {
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
                } else {
                    return $this->render('PrivlinkBundle:privlink:empty_page.html.twig');
                }
            } else {
                return $this->render('PrivlinkBundle:privlink:empty_page.html.twig');
            }

        }



}



