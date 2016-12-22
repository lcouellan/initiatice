<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * News REST api
 * Class NewsController
 * @package initiatice\ApiBundle\Controller
 */
class NewsController extends Controller
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
     * List news
     * Route: /api/news/list
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
        $news = $this->getBd()->getRepository('initiaticeAdminBundle:News')->findBy($findBy, null, $limit, null);
        $data = [];
        foreach($news as $new)
            $data[] = $this->serializer->normalize($new, null);
        return $this->getJsonResponse($data);
    }

    /**
     * Show a news by ID
     * Route: /api/news/show/{id}
     * @param $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $new = $this->getBd()->getRepository('initiaticeAdminBundle:News')->find($id);
        if(!$new) return $this->getJsonResponse(['msg' => 'NEWS ID IS NOT VALID'])->setStatusCode(400);
        return $this->getJsonResponse($this->serializer->normalize($new, null));
    }
}
