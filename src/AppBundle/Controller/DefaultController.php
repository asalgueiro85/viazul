<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/login", name="login")
     *
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR,
            $session->get(SecurityContext::AUTHENTICATION_ERROR));
        return $this->render(':default:login.html.twig', array(
                'error' => $error,
                'last_username' => $session->get(SecurityContext::LAST_USERNAME)
            )
        );
    }

    /**
     * @Route("/provincias", name="obtener_provincias")
     */
    public function prbinciasAction()
    {
        $data = $this->container->get('besimple.soap.client.capital_humano')->ObtenerProvincias();

       return new JsonResponse($data);
//        return array(
//            'data' => $provincias
//        );
    }

    /**
     * Reportes
     *
     * @Route("/imprimir", name="imprimir")
     *
     */
    public function imprimirAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $areas = $this->container->get('besimple.soap.client.capital_humano')->ObtenerAreas();
        $destino = $this->container->get('besimple.soap.client.capital_humano')->ObtenerProvincias();
        $causas = $em->getRepository('AppBundle:Causa')->findAll();
        return $this->render('AppBundle:Reportes:index.html.twig', array(
            'entities' => null,
            'areas'=>$areas,
            'destinos'=>$destino,
            'causas'=>$causas,
        ));
    }

    /**
     * Reportes
     *
     * @Route("/imprimir_actualizar", name="imprimir_actualizar")
     *
     */
    public function imprimir_actualizarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $areas = $this->container->get('besimple.soap.client.capital_humano')->ObtenerAreas();
        $causas = $em->getRepository('AppBundle:Causa')->findAll();
        $destino = $this->container->get('besimple.soap.client.capital_humano')->ObtenerProvincias();
        $entities = $em->getRepository('AppBundle:Bauche')->findByParams($request->get('appbundle_causa_reporte'), $request->get('appbundle_area_reporte'), $request->get('appbundle_destino_reporte'), $request->get('appbundle_fecha_desde'),$request->get('appbundle_fecha_desde'));

        return $this->render('AppBundle:Reportes:index.html.twig', array(
            'entities' => $entities,
            'areas'=>$areas,
            'causas'=>$causas,
            'destinos'=>$destino,
        ));



    }

    /**
     * Reportes
     *
     * @Route("/imprimir_reporte", name="imprimir_reporte")
     *
     */
    public function imprimir_reporteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $areas = $this->container->get('besimple.soap.client.capital_humano')->ObtenerAreas();
        $causas = $em->getRepository('AppBundle:Causa')->findAll();
        $destino = $this->container->get('besimple.soap.client.capital_humano')->ObtenerProvincias();
//        $entities = $em->getRepository('AppBundle:Bauche')->findByParams($request->get('appbundle_causa_reporte'), $request->get('appbundle_area_reporte'), $request->get('appbundle_destino_reporte'), $request->get('appbundle_fecha_desde'),$request->get('appbundle_fecha_desde'));
        $entities = $em->getRepository('AppBundle:Bauche')->findAll();



        $html = $this->renderView('AppBundle:Reportes:reporte.html.twig' , array(
            'entities' => $entities,
        ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );



    }


}
