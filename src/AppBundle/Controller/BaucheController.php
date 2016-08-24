<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Bauche;
use AppBundle\Entity\Accion;
use AppBundle\Form\BaucheType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Bauche controller.
 *
 * @Route("/bauche")
 */
class BaucheController extends Controller
{

    /**
     * Lists all Bauche entities.
     *
     * @Route("/", name="bauche")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Bauche')->findAll();

        return array(
            'entities' => $entities
        );
    }

    /**
     * Creates a new Bauche entity.
     *
     * @Route("/", name="bauche_create")
     * @Method("POST")
     * @Template("AppBundle:Bauche:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Bauche();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Configuracion')->findAll();

        $conf = $entities[0];

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $accion = new Accion();
            $accion->setNombre('Registro de Bauche');
            $accion->setDescripcion('Se crea bauche con destino: '.$entity->getDestino());
            $accion->setImporte($entity->getImporte());
            $accion->setFecha($entity->getFechaEmitido());

            $em->persist($entity);
            $em->persist($accion);

            if($entity->isEstado()){
                $entity->setFechaConsumo(new \DateTime);
                $accion2 = new Accion();
                $accion2->setNombre('Consumo de Bauche');
                $accion2->setDescripcion('Se registra el consumo del bauche a nombre de: '.$entity->getNombre());
                $accion2->setImporte($entity->getImporte());
                $accion2->setFecha($entity->getFechaConsumo());
                $conf->setFondo($conf->getFondo()-$entity->getImporte());
                $em->persist($accion2);

            }
            $em->flush();

            return $this->redirect($this->generateUrl('bauche'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Bauche entity.
     *
     * @param Bauche $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Bauche $entity)
    {
        $destino = $this->container->get('besimple.soap.client.capital_humano')->ObtenerProvincias();
        $areas = $this->container->get('besimple.soap.client.capital_humano')->ObtenerAreas();
        $form = $this->createForm(new BaucheType($destino, $areas), $entity, array(
            'action' => $this->generateUrl('bauche_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new Bauche entity.
     *
     * @Route("/new", name="bauche_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Bauche();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Bauche entity.
     *
     * @Route("/{id}", name="bauche_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Bauche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bauche entity.');
        }


        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Bauche entity.
     *
     * @Route("/{id}/edit", name="bauche_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Bauche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bauche entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Bauche entity.
     *
     * @param Bauche $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Bauche $entity)
    {
        $destino = $this->container->get('besimple.soap.client.capital_humano')->ObtenerProvincias();
        $areas = $this->container->get('besimple.soap.client.capital_humano')->ObtenerAreas();
        $form = $this->createForm(new BaucheType($destino, $areas), $entity, array(
            'action' => $this->generateUrl('bauche_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Bauche entity.
     *
     * @Route("/{id}", name="bauche_update")
     * @Method("PUT")
     * @Template("AppBundle:Bauche:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Bauche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bauche entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $accion = new Accion();
            $accion->setNombre('Editar Bauche');
            $accion->setDescripcion('Se edita el bauche con destino: '.$entity->getDestino(). ' a nombre de'.$entity->getNombre());
            $accion->setImporte($entity->getImporte());
            $accion->setFecha(new \DateTime());

            $em->persist($entity);
            $em->persist($accion);

            if($entity->isEstado()){
                if($entity->getFechaConsumo() == null){
                    $entity->setFechaConsumo(new \DateTime());
                }else{
                    $entity->setFechaConsumo(null);
                }
                $accion2 = new Accion();
                $accion2->setNombre('Consumo de Bauche');
                $accion2->setDescripcion('Se registra el consumo del bauche a nombre de: '.$entity->getNombre());
                $accion2->setImporte($entity->getImporte());
                $accion2->setFecha(new \DateTime());

                $entities = $em->getRepository('AppBundle:Configuracion')->findAll();
                $conf = $entities[0];
                $conf->setFondo($conf->getFondo()-$entity->getImporte());
                $em->persist($accion2);

            }

            $em->flush();

            return $this->redirect($this->generateUrl('bauche'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Bauche entity.
     *
     * @Route("/{id}/delete", name="bauche_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Bauche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bauche entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('bauche'));
    }
}

