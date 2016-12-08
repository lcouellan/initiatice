<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\ApiBundle\Entity\Teacher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TeacherController extends Controller
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
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');
        $findBy = [];
        if($request->query->get('profile') != null) $findBy['profile'] = $request->query->get('profile');

        $teachers = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:Teacher')
            ->findBy($findBy, null, $limit, null);
        $data = [];
        foreach($teachers as $teacher) {
            $data[] = $this->serializer->normalize($teacher, null);
        }
        return $this->getJsonResponse($data);
    }

    /**
     * Voir un evenement
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $teacher = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:Teacher')
            ->find($id);
        return $this->getJsonResponse($this->serializer->normalize($teacher, null));
    }
}
