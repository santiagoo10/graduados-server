<?php


namespace App\Controller;


use ApiPlatform\Core\Api\IriConverterInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class SecurityController extends AbstractController
{


    private $logger;

//    public function __constructor(LoggerInterface $logger){
//       $this->logger = $logger;
//    }

//    /**
//     * @Route("/login", name="app_login", methods={"POST"})
//     * @param IriConverterInterface $iriConverter
//     * @param LoggerInterface $logger
//     * @return JsonResponse|Response
//     */
//    public function login( IriConverterInterface $iriConverter, LoggerInterface $logger){
//
//        $user = $this->getUser();
//
//
//        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
//            return $this->json([
//                'error'=>'Invalid login request: check that the contentype problem.'
//            ], 400);
//        }
//
//        $this->logger->info('uusario: ');
//
//        $location =  $iriConverter->getIriFromItem($user);
//
//        return new Response(null, 204, [
//          'Location' => $location ,
//
//        ]);
//
//        return $this->json([
//                'user' => $user,
//                'roles' => $user->getRoles(),
//                'username' => $user->getUsername(),
//                'token' => $location
//        ]);
//    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('Should not be reached.');

    }
}
