<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Cuenta;
use AppBundle\Form\CuentaType;

/**
 * Cuenta controller.
 *
 * @Route("/cuenta")
 *
 */
class CuentaController extends Controller
{

    /**
     * Lists all Cuenta entities.
     *
     * @Route("/", name="cuenta")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Cuenta')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cuenta entity.
     *
     * @Route("/", name="cuenta_create")
     * @Method("POST")
     * @Template("AppBundle:Cuenta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cuenta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('AppBundle:Cuenta')->findAll();

            if($entities){
                throw $this->createNotFoundException('No se puede agregar otra cuenta');
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cuenta'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Cuenta entity.
     *
     * @param Cuenta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cuenta $entity)
    {
        $form = $this->createForm(new CuentaType(), $entity, array(
            'action' => $this->generateUrl('cuenta_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Cuenta entity.
     *
     * @Route("/new", name="cuenta_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cuenta();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cuenta entity.
     *
     * @Route("/{id}", name="cuenta_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cuenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cuenta entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Cuenta entity.
     *
     * @Route("/{id}/edit", name="cuenta_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cuenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cuenta entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Cuenta entity.
    *
    * @param Cuenta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cuenta $entity)
    {
        $form = $this->createForm(new CuentaType(), $entity, array(
            'action' => $this->generateUrl('cuenta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Cuenta entity.
     *
     * @Route("/{id}", name="cuenta_update")
     * @Method("PUT")
     * @Template("AppBundle:Cuenta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cuenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cuenta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cuenta'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Cuenta entity.
     *
     * @Route("/{id}/delete", name="cuenta_delete")
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Cuenta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cuenta entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('cuenta'));
    }

}
