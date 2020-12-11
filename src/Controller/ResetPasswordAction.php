<?php


namespace App\Controller;


use App\Entity\User;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordAction
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var JWTTokenManagerInterface
     */
    private JWTTokenManagerInterface $JWTTokenManager;

    public function __construct(
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $JWTTokenManager
    )
    {
       $this->encoder = $encoder;
       $this->entityManager = $entityManager;
       $this->validator = $validator;
       $this->JWTTokenManager = $JWTTokenManager;
    }
    public function __invoke(User $data): JsonResponse
    {
        $this->validator->validate($data);
        $data->setPassword($this->encoder->encodePassword($data, $data->getNewPassword()));
        $data->setPasswordChangeDate(time());
        $token = $this->JWTTokenManager->create($data);
        $this->entityManager->flush();
        return new JsonResponse(['token' => $token]);
    }

}