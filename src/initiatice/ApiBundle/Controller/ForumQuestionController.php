<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\ApiBundle\Entity\ForumQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ForumQuestionController extends Controller
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
     * Liste de questions
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');

        $questions = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:ForumQuestion')
            ->findBy([], null, $limit, null);
        $data = [];
        foreach($questions as $question) {
            $data[] = $this->serializer->normalize($question, null);
        }
        return $this->getJsonResponse($data);
    }

    /**
     * Voir une question
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $question = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:ForumQuestion')
            ->find($id);
        return $this->getJsonResponse($this->serializer->normalize($question, null));
    }
}
