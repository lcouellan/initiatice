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

/**
 * Profile REST api
 *
 * Class ProfileController
 * @package initiatice\ApiBundle\Controller
 */
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
     * List profiles from /api/profile/list
     *
     * [GET] <b>limit <i>(number)</i></b> to limit the results <i>Not required</i>
     * @param Request $request
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
     * Show a profile by ID from /api/profile/show/{id}
     *
     * @param $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $profile = $this->getBd()->getRepository('initiaticeAdminBundle:Profile')->find($id);
        if(!$profile) return $this->getJsonResponse(['msg' => 'PROFILE ID IS NOT VALID'])->setStatusCode(400);
        return $this->getJsonResponse($this->serializer->normalize($profile, null));
    }
}
