<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\ApiBundle\Entity\ForumComment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ForumCommentController extends Controller
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
     * Liste de commentaires
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');

        $findBy = [];
        if($request->query->get('question') != null) $findBy['questionId'] = $request->query->get('question');

        $comments = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:ForumComment')
            ->findBy($findBy, null, $limit, null);
        $data = [];
        foreach($comments as $comment) {
            $data[] = $this->serializer->normalize($comment, null);
        }
        return $this->getJsonResponse($data);
    }

    /**
     * Voir un commentaire
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $comment = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:ForumComment')
            ->find($id);
        return $this->getJsonResponse($this->serializer->normalize($comment, null));
    }
}
