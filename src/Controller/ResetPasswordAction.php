<?php


namespace App\Controller;


use App\Entity\User;
use ApiPlatform\Core\Validator\ValidatorInterface;
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

    public function __construct(
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $encoder
    )
    {
       $this->encoder = $encoder;

        $this->validator = $validator;
    }
    public function __invoke(User $data): User
    {
        $this->validator->validate($data);
        $data->setPassword($this->encoder->encodePassword($data, $data->getNewPassword()));
        return $data;
    }

}