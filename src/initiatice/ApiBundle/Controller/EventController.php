<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\ApiBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EventController extends Controller
{
    private $serializer;
    public function __construct() {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
    }
    private function getJsonResponse($data) {
        $response = new JsonResponse();
        $response->setData($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Liste d'evenements
     * @return JsonResponse
     */
    public function listAction()
    {
        $events = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:Event')
            ->findAll();

        $data = [];
        foreach($events as $event) {
            $data[] = $this->serializer->normalize($event, null);
        }
        return $this->getJsonResponse($data);
    }

    /**
     * Voir un evenement
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $event = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:Event')
            ->find($id);
        return $this->getJsonResponse($this->serializer->normalize($event, null));
    }
}
