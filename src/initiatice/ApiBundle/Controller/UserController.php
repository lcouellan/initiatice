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
            if(!$user) return $this->getJsonResponse(['msg' => 'SOME FIELD IS NOT VALID'])->setStatusCode(400);
            $user->setTokenGoogle($request->request->get('google'));
            $this->getBd()->persist($user);
            $this->getBd()->flush();
            return $this->getJsonResponse(['msg' => 'USER GOOGLE TOKEN ADDED'])->setStatusCode(201);
        }
        return $this->getJsonResponse(['msg' => 'SOME FIELD IS MISSING'])->setStatusCode(400);
    }

    /*
    * Modifier un utilisateur
    * @return JsonResponse
    */
    public function editAction(Request $request)
    {
        /*
         * Validation
         */
        $isNotNull = $request->request->get('token') && $request->request->get('email')
                    && $request->request->get('key');
        $isNotEmpty = sizeof($request->request->get('token')) > 0 && sizeof($request->request->get('email')) > 0
                    && sizeof($request->request->get('key')) > 0;
        $switch = [
            'firstname' => function($u, $req)   { $u->setFirstname( substr($req->request->get('value'), 0, 255) ); },
            'lastname' => function($u, $req)    { $u->setLastname( substr($req->request->get('value'), 0, 255) ); },
            'description' => function($u, $req) { $u->setDescription( substr($req->request->get('value'), 0, 5000) ); },
            'profile' => function($u, $req)     { $u->setProfile( $req->request->get('value') ); }
        ];
        if(!array_key_exists($request->request->get('key'), $switch))
            return $this->getJsonResponse(['msg' => 'KEY IS NOT VALID'])->setStatusCode(400);

        // Modification en DB
        if($isNotNull && $isNotEmpty) {
            $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')
                ->findBy(['email' => $request->request->get('email'), 'token' => $request->request->get('token')], null, null, null)[0];
            if(!$user) return $this->getJsonResponse(['msg' => 'EMAIL OR TOKEN IS NOT VALID'])->setStatusCode(400);
            $switch[$request->request->get('key')]($user, $request);
            $user->setDateUpdate(new \DateTime());
            $this->getBd()->persist($user);
            $this->getBd()->flush();
            return $this->getJsonResponse(['msg' => 'USER EDITED', 'user' => $user->getMyInfos()])->setStatusCode(201);
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
        /*
         * Validation
         */
        $isNotNull = $request->request->get('email')
            && $request->request->get('plainPassword');
        $isNotEmpty = sizeof($request->request->get('email')) > 0
            && sizeof($request->request->get('plainPassword')) > 0;;

        /*
        * Auth
        */
        if($isNotNull && $isNotEmpty) {
            $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')
                ->findBy(['email' => $request->request->get('email')], null, null, null)[0];
            if(!$user) return $this->getJsonResponse(['msg' => 'EMAIL IS NOT VALID'])->setStatusCode(400);
            $e = $this->getEncoderFactory()->getEncoder($user);
            if($e->isPasswordValid($user->getPassword(), $request->request->get('plainPassword'), $user->getSalt()))
                return $this->getJsonResponse(['msg' => 'AUTH SUCCESS', 'user' => $user->getMyInfos()])->setStatusCode(200);
            return $this->getJsonResponse(['msg' => 'PASSWORD NOT CORRECT'])->setStatusCode(400);
        }
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
        if(!$user) return $this->getJsonResponse(['msg' => 'USER ID IS NOT VALID'])->setStatusCode(400);
        return $this->getJsonResponse($user->getOtherInfos());
    }
}
