<?php

namespace PrivlinkBundle\Controller;

use PrivlinkBundle\Entity\privlink;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PrivlinkBundle\Form\privlinkType;

/**
 * Privlink controller.
 *
 * @Route("privlink")
 */
class privlinkController extends Controller
{

    /**
     * Creates a new privlink entity.
     *
     * @Route("/", name="privlink_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {


        $privlink = new Privlink();
        $form = $this->createForm('PrivlinkBundle\Form\privlinkType', $privlink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //get request from form
            $endDate = $request->request->get('privlinkbundle_privlink')['endDate'];
            $password = $request->request->get('privlinkbundle_privlink')['password'];
            if ($password) {
                $password = md5($password);
                $privlink->setPassword($password);
            }

            if ($endDate != null)
            {
                // get today's datetime
                $date = new \DateTime('now');
                // plus interval from form
                $up_date = $date->add(new \DateInterval('P' . $endDate . 'D'));
                $privlink->setEndDate($up_date);
            } else
                {
                    //set endDate NULL
                $privlink->setEndDate(null);
                }

            //get hash with ten symbols
            $hash = substr(md5(uniqid()), 0, 10);
            $privlink->setHash($hash);
            $configuration = true;
            $privlink->setConfiguration($configuration);
            //call function to get user ip address
            $user_ip = $this->get_user_ip();
            $privlink->setCreatedFromIp($user_ip);
            $em = $this->getDoctrine()->getManager();
            $em->persist($privlink);
            $em->flush();

            return $this->render('PrivlinkBundle:privlink:show.html.twig', array(
                'privlink' => $privlink,
            ));
        }

        return $this->render('PrivlinkBundle:privlink:new.html.twig', array(
            'privlink' => $privlink,
            'form' => $form->createView(),
        ));
    }



    // Determine the IP address of the user
    public function get_user_ip(){
        $client = @$_SERVER{'HTTP_CLIENT_IP'};
        $forward = @$_SERVER{'HTTP_X_FORWARDER_FOR'};
        $remote = @$_SERVER{'REMOTE_ADDR'};

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip_addr = $forward;
        } else
        {
            $ip_addr = $remote;
        }
        return $ip_addr;
    }

}
