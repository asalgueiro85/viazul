<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Causa;
use AppBundle\Form\CausaType;

/**
 * Causa controller.
 *
 * @Route("/causa")
 */
class CausaController extends Controller
{

    /**
     * Lists all Causa entities.
     *
     * @Route("/", name="causa")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Causa')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Causa entity.
     *
     * @Route("/", name="causa_create")
     * @Method("POST")
     * @Template("AppBundle:Causa:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Causa();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('causa'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Causa entity.
     *
     * @param Causa $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Causa $entity)
    {
        $form = $this->createForm(new CausaType(), $entity, array(
            'action' => $this->generateUrl('causa_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Causa entity.
     *
     * @Route("/new", name="causa_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Causa();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Causa entity.
     *
     * @Route("/{id}", name="causa_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Causa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }


        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Causa entity.
     *
     * @Route("/{id}/edit", name="causa_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Causa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Causa entity.
    *
    * @param Causa $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Causa $entity)
    {
        $form = $this->createForm(new CausaType(), $entity, array(
            'action' => $this->generateUrl('causa_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Causa entity.
     *
     * @Route("/{id}", name="causa_update")
     * @Method("PUT")
     * @Template("AppBundle:Causa:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Causa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Causa entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('causa'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Causa entity.
     *
     * @Route("/{id}/delete", name="causa_delete")
     */
    public function deleteAction(Request $request, $id)
    {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Causa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Causa entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('causa'));
    }

}
