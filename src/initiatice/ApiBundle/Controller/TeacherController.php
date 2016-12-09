<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\ApiBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserController extends Controller
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
     * Liste d'evenements
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');
        $findBy = [];
        if($request->query->get('profile') != null)
            $findBy['profile'] = $request->query->get('profile');
        $users = $this->getBd()->getRepository('initiaticeAdminBundle:User')->findBy($findBy, null, $limit, null);
        $data = [];
        foreach($users as $user)
            $data[] = $this->serializer->normalize($user, null);
        return $this->getJsonResponse($data);
    }

    /**
     * Voir un evenement
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($id);
        return $this->getJsonResponse($this->serializer->normalize($user, null));
    }
}
