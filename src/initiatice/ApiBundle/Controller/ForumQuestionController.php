<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\ForumQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Forum question REST api
 *
 * Class ForumQuestionController
 * @package initiatice\ApiBundle\Controller
 */
class ForumQuestionController extends Controller
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
     * Add a question from /api/forum/question/add
     *
     * [GET] <b>userId <i>(number)</i></b> to link an user <i>Required</i> <br/>
     * [GET] <b>title <i>(string)</i></b> for your question <i>Required</i> <br/>
     * [GET] <b>content <i>(string)</i></b> for your question <i>Required</i>
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        /** @var boolean $isNotNull equals false if a params is undefined */
        $isNotNull = $request->request->get('userId')
            && $request->request->get('content')
            && $request->request->get('title');

        /** @var boolean $isNotEmpty equals false if a params is empty */
        $isNotEmpty = sizeof($request->request->get('userId')) > 0
            && sizeof($request->request->get('content')) > 0
            && sizeof($request->request->get('title')) > 0;

        /** Add if OK */
        if($isNotNull && $isNotEmpty) {
            $question = new ForumQuestion();
            $question->setUserId( substr($request->request->get('userId'), 0, 15) );
            $question->setContent( substr($request->request->get('content'), 0, 999999) );
            $question->setTitle( substr($request->request->get('title'), 0, 255) );
            $question->setDateAdd(new \DateTime());
            $question->setDateUpdate(new \DateTime());
            $this->getBd()->persist($question);
            $this->getBd()->flush();
            return $this->getJsonResponse(['msg' => 'QUESTION ADDED'])->setStatusCode(201);
        }
        return $this->getJsonResponse(['msg' => 'SOME FIELD IS MISSING'])->setStatusCode(400);
    }

    /**
     * List questions from /api/forum/question/list
     *
     * [GET] <b>limit <i>(number)</i></b> to limit the results <i>Not required</i>
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        /** @var number $limit to limit results (equals 1 or more) */
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');

        $questions = $this->getDoctrine()
            ->getRepository('initiaticeAdminBundle:ForumQuestion')
            ->findBy([], null, $limit, null);
        $data = [];
        foreach($questions as $question) {
            $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($question->getUserId());
            $q = $this->serializer->normalize($question, null);
            $q['user'] = $user->getOtherInfos();
            $data[] = $q;
        }
        return $this->getJsonResponse($data);
    }

    /**
     * Show a question by ID from /api/forum/question/show/{id}
     *
     * @param $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $question = $this->getDoctrine()->getRepository('initiaticeAdminBundle:ForumQuestion')->find($id);
        if(!$question) return $this->getJsonResponse(['msg' => 'QUESTION ID IS NOT VALID'])->setStatusCode(400);
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($question->getUserId());
        if(!$user) return $this->getJsonResponse(['msg' => 'USER ID IN QUESTION IS NOT VALID'])->setStatusCode(400);
        $q = $this->serializer->normalize($question, null);
        $q['user'] = $user->getOtherInfos();
        return $this->getJsonResponse($q);
    }
}
