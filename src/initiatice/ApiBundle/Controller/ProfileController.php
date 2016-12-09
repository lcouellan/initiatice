<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\Profile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProfileController extends Controller
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
     * Liste de profils
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');
        $profiles = $this->getBd()->getRepository('initiaticeAdminBundle:Profile')->findBy([], null, $limit, null);
        $data = [];
        foreach($profiles as $profile)
            $data[] = $this->serializer->normalize($profile, null);
        return $this->getJsonResponse($data);
    }

    /**
     * Voir un profil
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $profile = $this->getBd()->getRepository('initiaticeAdminBundle:Profile')->find($id);
        return $this->getJsonResponse($this->serializer->normalize($profile, null));
    }
}
