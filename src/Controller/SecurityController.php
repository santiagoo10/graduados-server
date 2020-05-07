<?php


namespace App\Controller;


use ApiPlatform\Core\Api\IriConverterInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     * @param IriConverterInterface $iriConverter
     * @return JsonResponse|Response
     */
    public function login( IriConverterInterface $iriConverter){

        $user = $this->getUser();


        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->json([
                'error'=>'Invalid login request: check that the contentype problem.'
            ], 400);
        }


        return new Response(null, 204, [
          'Location' => $iriConverter->getIriFromItem($user),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('Should not be reached.');

    }
}
