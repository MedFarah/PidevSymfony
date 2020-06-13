<?php

namespace LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiMobileController extends Controller
{
    public function loginMobileAction($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $data = [
            'type' => 'validation error',
            'title' => 'There was a validation error',
            'errors' => 'username or password invalide'
        ];
        $response = new JsonResponse($data, 400);


        $user = $user_manager->findUserByUsername($username);
        if (!$user)
            return $response;


        $encoder = $factory->getEncoder($user);

        $bool = ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) ? "true" : "false";
        if ($bool == "true") {
            $role = $user->getRoles();

            $data = array(
                'type' => 'Login succeed',
                'id' => $user->getId(),


                'email' => $user->getEmail(),


                'role' => $user->getRoles()
            );
            $response = new JsonResponse($data, 200);
            return $response;
        } else {
            return $response;
        }
    }
}
