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
     * Ajouter un utilisateur
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
            $user = new User();
            $e = $this->getEncoderFactory()->getEncoder($user);
            $user->setFirstname( substr($request->request->get('firstname'), 0, 255) );
            $user->setLastname( substr($request->request->get('lastname'), 0, 255) );
            $user->setEmail( substr($request->request->get('email'), 0, 255) );
            $user->setProfile( substr($request->request->get('profile'), 0, 2) );
            $user->setPlainPassword( substr($request->request->get('plainPassword'), 0, 4096) );
            $user->setPassword($e->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->setToken(bin2hex(random_bytes(48)));
            $user->setDateAdd(new \DateTime());
            $user->setDateUpdate(new \DateTime());
            $user->setEnabled(true);
            $this->getBd()->persist($user);
            $this->getBd()->flush();
            return $this->getJsonResponse(['msg' => 'OK: USER ADDED', 'http_code' => 201, 'token' => $user->getToken()]);
        }
        return new Response('ERROR: USER NOT ADDED', 400);
    }

    /*
     * Récupérer token utilisateur pour connexion
     */
    public function authAction(Request $request)
    {
        if($request->query->get('email') == null && $request->query->get('plainPassword') == null)
            return new Response('ERROR: USER NOT RETURNED', 400);

        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')
            ->findBy(['email' => $request->query->get('email')], null, null, null);
        $e = $this->getEncoderFactory()->getEncoder($user);
        if($request->query->get('plainPassword') == $user->getPlainPassword())
            return $this->getJsonResponse([
                'firstname' => $user->getFirstname(),       'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),               'profile' => $user->getProfile(),
                'description' => $user->getDescription(),   'enabled' => $user->isEnabled(),
                'dateAdd' => $user->getDateAdd(),           'dateUpdate' => $user->getDateUpdate(),
                'token' => $user->getToken()
            ]);
        else
            return new Response('ERROR: PASSWORD NOT CORRECT', 400);
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
        foreach($users as $user) {
            $data[] = [
                'firstname' => $user->getFirstname(),       'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),               'profile' => $user->getProfile(),
                'description' => $user->getDescription(),   'enabled' => $user->isEnabled(),
                'dateAdd' => $user->getDateAdd(),           'dateUpdate' => $user->getDateUpdate()
            ];
        }

        return $this->getJsonResponse($data);
    }

    /**
     * Voir un utilisateur
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $user = $this->getBd()->getRepository('initiaticeAdminBundle:User')->find($id);
        return $this->getJsonResponse([
            'firstname' => $user->getFirstname(),       'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),               'profile' => $user->getProfile(),
            'description' => $user->getDescription(),   'enabled' => $user->isEnabled(),
            'dateAdd' => $user->getDateAdd(),           'dateUpdate' => $user->getDateUpdate()
        ]);
    }
}
