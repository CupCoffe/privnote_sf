<?php

namespace PrivlinkBundle\Controller;

use PrivlinkBundle\Entity\privlink;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Privlink controller.
 *
 * @Route("privlink")
 */
class privlinkController extends Controller
{
    /**
     * Lists all privlink entities.
     *
     * @Route("/", name="privlink_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $privlinks = $em->getRepository('PrivlinkBundle:privlink')->findAll();

        return $this->render('PrivlinkBundle:privlink:index.html.twig', array(
            'privlinks' => $privlinks,
        ));

    }

    /**
     * Creates a new privlink entity.
     *
     * @Route("/new", name="privlink_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $privlink = new Privlink();
        $form = $this->createForm('PrivlinkBundle\Form\privlinkType', $privlink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTime('now');
            $privlink->setCreateDate($now);
            $hash = substr(md5(uniqid()), 0, 10);
            $privlink->setHash($hash);
            $configuration = true;
            $privlink->setConfiguration($configuration);
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
        $deleteForm = $this->createDeleteForm($privlink);

        return $this->render('PrivlinkBundle:privlink:show.html.twig', array(
            'privlink' => $privlink,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing privlink entity.
     *
     * @Route("/{id}/edit", name="privlink_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, privlink $privlink)
    {
        $deleteForm = $this->createDeleteForm($privlink);
        $editForm = $this->createForm('PrivlinkBundle\Form\privlinkType', $privlink);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('privlink_edit', array('id' => $privlink->getId()));
        }

        return $this->render('PrivlinkBundle:privlink:edit.html.twig', array(
            'privlink' => $privlink,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a privlink entity.
     *
     * @Route("/{id}", name="privlink_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, privlink $privlink)
    {
        $form = $this->createDeleteForm($privlink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($privlink);
            $em->flush();
        }

        return $this->redirectToRoute('privlink_index');
    }

    /**
     * Creates a form to delete a privlink entity.
     *
     * @param privlink $privlink The privlink entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(privlink $privlink)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('privlink_delete', array('id' => $privlink->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
