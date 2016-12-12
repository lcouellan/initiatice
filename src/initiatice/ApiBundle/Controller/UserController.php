<?php

namespace initiatice\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use initiatice\AdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    private function getEncoderFactory() { return $this->container->get('security.encoder_factory'); }
    private function getJsonResponse($data) {
        $response = new JsonResponse();
        $response->setData($data)->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /*
     * Ajouter un token google à un utilisateur
     * @return JsonResponse
     */
    public function googleAddAction(Request $request)
    {
        /*
         * Validation
         */
        $isNotNull = $request->request->get('email') && $request->request->get('token')
            && $request->request->get('google');
        $isNotEmpty = sizeof($request->request->get('email')) > 0 && sizeof($request->request->get('token')) > 0
            && sizeof($request->request->get('google')) > 0;

        /*
         * Ajout token google
         */
        if($isNotNull && $isNotEmpty) {
            $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->findBy([
                'token' => $request->request->get('token'),
                'email' => $request->request->get('email')
            ], null, null, null)[0];
            $user->setTokenGoogle($request->request->get('google'));
            $this->getBd()->persist($user);
            $this->getBd()->flush();
            return $this->getJsonResponse(['msg' => 'USER GOOGLE TOKEN ADDED'])->setStatusCode(201);
        }
        return $this->getJsonResponse(['msg' => 'SOME FIELD IS MISSING'])->setStatusCode(400);
    }

    /*
     * Ajouter un utilisateur
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        /*
         * Validation
         */
        $isNotNull = $request->request->get('firstname') && $request->request->get('lastname')
            && $request->request->get('email') && $request->request->get('profile')
            && $request->request->get('plainPassword');

        $isNotEmpty = sizeof($request->request->get('firstname')) > 0 && sizeof($request->request->get('lastname')) > 0
            && sizeof($request->request->get('email')) > 0 && sizeof($request->request->get('profile')) > 0
            && sizeof($request->request->get('plainPassword')) > 0;

        /*
         * Ajout
         */
        if($isNotNull && $isNotEmpty) {

            $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')
                ->findBy(['email' => $request->request->get('email')], null, null, null)[0];
            if($user) return $this->getJsonResponse(['msg' => 'EMAIL ALREADY REGISTERED'])->setStatusCode(400);

            $user = new User();
            $e = $this->getEncoderFactory()->getEncoder($user);
            $user->setFirstname( substr($request->request->get('firstname'), 0, 255) );
            $user->setLastname( substr($request->request->get('lastname'), 0, 255) );
            $user->setEmail( substr($request->request->get('email'), 0, 255) );
            $user->setProfile( substr($request->request->get('profile'), 0, 2) );
            $user->setPlainPassword( substr($request->request->get('plainPassword'), 0, 4096) );
            $user->setSalt(uniqid(mt_rand(), true));
            $user->setPassword($e->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->setToken(bin2hex(random_bytes(48)));
            $user->setDateAdd(new \DateTime());
            $user->setDateUpdate(new \DateTime());
            $user->setEnabled(true);
            $this->getBd()->persist($user);
            $this->getBd()->flush();
            return $this->getJsonResponse(['msg' => 'USER ADDED', 'user' => $user->getMyInfos()])->setStatusCode(201);
        }
        return $this->getJsonResponse(['msg' => 'SOME FIELD IS MISSING'])->setStatusCode(400);
    }

    /*
     * Récupérer token utilisateur pour connexion
     * @return JsonResponse
     */
    public function authAction(Request $request)
    {
        if($request->request->get('email') && $request->request->get('plainPassword')) {
            $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')
                ->findBy(['email' => $request->request->get('email')], null, null, null)[0];
            $e = $this->getEncoderFactory()->getEncoder($user);
            if($e->isPasswordValid($user->getPassword(), $request->request->get('plainPassword'), $user->getSalt()))
                return $this->getJsonResponse(['msg' => 'AUTH SUCCESS', 'user' => $user->getMyInfos()])->setStatusCode(200);
            else
                return $this->getJsonResponse(['msg' => 'PASSWORD NOT CORRECT'])->setStatusCode(400);
        } else
            return $this->getJsonResponse(['msg' => '"email" OR "plainPassword" IS MISSING'])->setStatusCode(400);
    }

    /**
     * Liste d'utilisateurs
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $limit = $request->query->get('limit') == null ? null : $request->query->get('limit');
        $findBy = [];
        if($request->query->get('profile') != null)
            $findBy['profile'] = $request->query->get('profile');
        $users = $this->getBd()->getRepository('initiaticeAdminBundle:User')
            ->findBy($findBy, null, $limit, null);
        $data = [];
        foreach($users as $user)
            $data[] = $user->getOtherInfos();

        return $this->getJsonResponse($data);
    }

    /**
     * Voir un utilisateur
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($id);
        return $this->getJsonResponse($user->getOtherInfos());
    }
}
