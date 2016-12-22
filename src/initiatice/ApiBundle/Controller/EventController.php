<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Event REST api
 * Class EventController
 * @package initiatice\ApiBundle\Controller
 */
class EventController extends Controller
{
    private $serializer;
    public function __construct() {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
    }
    private function getBd() { return $this->getDoctrine()->getManager(); }
    private function getJsonResponse($data) {
        $response = new JsonResponse();
        $response->setData($data)->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * List events
     * Route: /api/event/list
     * NOT REQUIRED (GET)Attributes: limit (number), profile (Profile->id)
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');
        $findBy = [];
        if($request->query->get('profile') != null)
            $findBy['profile'] = $request->query->get('profile');
        $events = $this->getBd()->getRepository('initiaticeAdminBundle:Event')->findBy($findBy, null, $limit, null);
        $data = [];
        foreach($events as $event)
            $data[] = $this->serializer->normalize($event, null);
        return $this->getJsonResponse($data);
    }

    /**
     * Show an event by ID
     * Route: /api/event/show/{Event->id}
     * @param $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $event = $this->getBd()->getRepository('initiaticeAdminBundle:Event')->find($id);
        if(!$event) return $this->getJsonResponse(['msg' => 'EVENT ID IS NOT VALID'])->setStatusCode(400);
        return $this->getJsonResponse($this->serializer->normalize($event, null));
    }
}
