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

/**
 * Forum comment REST api
 *
 * Class ForumCommentController
 * @package initiatice\ApiBundle\Controller
 */
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

    /**
     * Add a comment from /api/forum/comment/add
     *
     * [GET] <b>question <i>(number)</i></b> to link a question <i>Required</i> <br/>
     * [GET] <b>userId <i>(number)</i></b> to link an user <i>Required</i> <br/>
     * [GET] <b>content <i>(string)</i></b> for your comment <i>Required</i>
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        /** @var boolean $isNotNull equals false if a params is undefined */
        $isNotNull = $request->request->get('userId')
            && $request->request->get('content')
            && $request->request->get('question');

        /** @var boolean $isNotEmpty equals false if a params is empty */
        $isNotEmpty = sizeof($request->request->get('userId')) > 0
            && sizeof($request->request->get('content')) > 0
            && sizeof($request->request->get('question')) > 0;

        /** Add if OK */
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
     * List comments from /api/forum/comment/list
     *
     * [GET] <b>limit <i>(number)</i></b> to limit the results <i>Not required</i> <br/>
     * [GET] <b>question <i>(number)</i></b> to find by a question <i>Not required</i>
     * @param Request $request
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
     * Show a comment by ID from /api/forum/comment/show/{id}
     *
     * @param $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $comment = $this->getBd()->getRepository('initiaticeAdminBundle:ForumComment')->find($id);
        if(!$comment) return $this->getJsonResponse(['msg' => 'COMMENT ID IS NOT VALID'])->setStatusCode(400);
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($comment->getUserId());
        if(!$user) return $this->getJsonResponse(['msg' => 'USER ID IN COMMENT IS NOT VALID'])->setStatusCode(400);
        $c = $this->serializer->normalize($comment, null);
        $c['user'] = $user->getOtherInfos();
        return $this->getJsonResponse($c);
    }
}
