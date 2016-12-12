<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\ForumComment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    private function getBd() { return $this->getDoctrine()->getManager(); }
    private function getJsonResponse($data) {
        $response = new JsonResponse();
        $response->setData($data)->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /*
     * Ajouter un commentaire
     */
    public function addAction(Request $request)
    {
        /*
         * Validation
         */
        $isNotNull = $request->request->get('userId')
            && $request->request->get('content')
            && $request->request->get('question');

        $isNotEmpty = sizeof($request->request->get('userId')) > 0
            && sizeof($request->request->get('content')) > 0
            && sizeof($request->request->get('question')) > 0;

        /*
         * Ajout
         */
        if($isNotNull && $isNotEmpty) {
            $comment = new ForumComment();
            $comment->setUserId( substr($request->request->get('userId'), 0, 15) );
            $comment->setContent( substr($request->request->get('content'), 0, 999999) );
            $comment->setQuestionId( substr($request->request->get('question'), 0, 15) );
            $comment->setDateAdd(new \DateTime());
            $comment->setDateUpdate(new \DateTime());
            $this->getBd()->persist($comment);
            $this->getBd()->flush();
            return $this->getJsonResponse(['msg' => 'COMMENT ADDED'])->setStatusCode(201);
        }
        return $this->getJsonResponse(['msg' => 'SOME FIELD IS MISSING'])->setStatusCode(400);
    }

    /**
     * Liste de commentaires
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');
        $findBy = [];
        if($request->query->get('question') != null)
            $findBy['questionId'] = $request->query->get('question');
        $comments = $this->getBd()->getRepository('initiaticeAdminBundle:ForumComment')->findBy($findBy, null, $limit, null);
        $data = [];
        foreach($comments as $comment) {
            $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($comment->getUserId());
            $c = $this->serializer->normalize($comment, null);
            $c['user'] = $user->getOtherInfos();
            $data[] = $c;
        }
        return $this->getJsonResponse($data);
    }

    /**
     * Voir un commentaire
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $comment = $this->getBd()->getRepository('initiaticeAdminBundle:ForumComment')->find($id);
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($comment->getUserId());
        $c = $this->serializer->normalize($comment, null);
        $c['user'] = $user->getOtherInfos();
        return $this->getJsonResponse($c);
    }
}
