<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Accion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Configuracion;
use AppBundle\Form\ConfiguracionType;

/**
 * Configuracion controller.
 *
 * @Route("/configuracion")
 */
class ConfiguracionController extends Controller
{

    /**
     * Lists all Configuracion entities.
     *
     * @Route("/", name="configuracion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Configuracion')->findAll();
        $acciones =  $em->getRepository('AppBundle:Accion')->findAll();

        if(count($entities) > 0){
            $entity = $entities[0];
        }else{
            return $this->redirect($this->generateUrl('configuracion_new'));
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'acciones'    => $acciones,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Creates a new Configuracion entity.
     *
     * @Route("/", name="configuracion_create")
     * @Method("POST")
     * @Template("AppBundle:Configuracion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Configuracion')->findAll();

        if(count($entities) > 0){
            throw $this->createNotFoundException('No se puede agregar más instancia de esta entidad');
        }else {

            $entity = new Configuracion();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {

                $accion = new Accion();
                $accion->setNombre('Creación de la Cuenta de Viazul');
                $accion->setDescripcion('Se crea la cuenta UCI destinada al consumo de los servicios de Viazul');
                $accion->setImporte($entity->getCuenta());
                $accion->setFecha(new \DateTime);

                $em->persist($accion);
                $entity->setFondo(0);
                $em->persist($entity);
                $em->flush();


                $acciones = $em->getRepository('AppBundle:Accion')->findAll();
                $entity = $entities[0];
                $editForm = $this->createEditForm($entity);

                return $this->redirect($this->generateUrl('configuracion', array(
                    'entity' => $entity,
                    'acciones' => $acciones,
                    'edit_form' => $editForm->createView(),
                )));
            }

            return array(
                'entity' => $entity,
                'form' => $form->createView(),
            );
        }
    }

    /**
     * Creates a form to create a Configuracion entity.
     *
     * @param Configuracion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Configuracion $entity)
    {
        $form = $this->createForm(new ConfiguracionType(), $entity, array(
            'action' => $this->generateUrl('configuracion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Configuracion entity.
     *
     * @Route("/new", name="configuracion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Configuracion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Configuracion entity.
     *
     * @Route("/{id}", name="configuracion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Configuracion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuracion entity.');
        }


        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Configuracion entity.
     *
     * @Route("/{id}/edit", name="configuracion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Configuracion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuracion entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Configuracion entity.
    *
    * @param Configuracion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Configuracion $entity)
    {
        $form = $this->createForm(new ConfiguracionType(), $entity, array(
            'action' => $this->generateUrl('configuracion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }
    /**
     * Edits an existing Configuracion entity.
     *
     * @Route("/{id}", name="configuracion_update")
     * @Method("PUT")
     * @Template("AppBundle:Configuracion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Configuracion')->find($id);
        $acciones = $em->getRepository('AppBundle:Accion')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuracion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $accion = new Accion();
            $accion->setNombre('Transferencia a los Fondos de Viazul');
            $accion->setDescripcion('Se transfirieron  '.$entity->getTrans().' CUC a los Fondos de Viazul');
            $accion->setImporte($entity->getTrans());
            $accion->setFecha(new \DateTime);
            $em->persist($accion);

            $entity->setCuenta($entity->getCuenta() - $entity->getTrans());
            $entity->setFondo($entity->getFondo() + $entity->getTrans());
            $entity->setTrans(null);

            $em->flush();

            return $this->redirect($this->generateUrl('configuracion'));
        }

        return array(
            'entity'      => $entity,
            'acciones'    => $acciones,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Configuracion entity.
     *
     * @Route("/{id}/delete", name="configuracion_delete")
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Configuracion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Configuracion entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('configuracion'));
    }


}
