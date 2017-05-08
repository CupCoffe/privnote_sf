<?php

namespace PrivlinkBundle\Controller;

use PrivlinkBundle\Entity\privlink;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
            $hash = substr(md5(uniqid()), 0, 10);
            $privlink->setHash($hash);
            $configuration = true;
            $privlink->setConfiguration($configuration);
            $user_ip = $this->get_user_ip();
            $privlink->setCreatedFromIp($user_ip);
            $em = $this->getDoctrine()->getManager();
            $em->persist($privlink);
            $em->flush();

            return $this->redirectToRoute('privlink_show', array('id' => $privlink->getId()));
        }

        return $this->render('PrivlinkBundle:privlink:new.html.twig', array(
            'privlink' => $privlink,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a privlink entity.
     *
     * @Route("/{id}", name="privlink_show")
     * @Method("GET")
     */
    public function showAction(privlink $privlink)
    {
        return $this->render('PrivlinkBundle:privlink:show.html.twig', array(
            'privlink' => $privlink,
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
