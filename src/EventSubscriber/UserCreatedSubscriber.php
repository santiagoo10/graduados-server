<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Graduate;
use App\Entity\Sale;
use App\Entity\User;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Kreait\Firebase\Auth;

class UserCreatedSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $auth;



    public function __construct(LoggerInterface $logger, Auth $auth)
    {
        $this->logger = $logger;
        $this->auth = $auth;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendPost', EventPriorities::POST_WRITE]
        ];
    }

    public function sendPost(ViewEvent $event){
        $value = $event->getControllerResult();
        switch (true){
            case ($value instanceof User):
                $roles= $value->getRoles();
                switch (end($roles)){
                    case 'ROLE_USER':
                        $this->sendUserPost($value);
                        break;
                    case 'ROLE_GRADUATE':
                        $this->sendGraduatePost($value );
                        break;
                }
                break;
            case ($value instanceof Sale):
                $this->sendSalePost();
                break;
        }
    }

    public function sendUserPost(User $user){
        //Todo enviar el user
        $this->logger->info('Envía un usuario');

    }

   public function sendSalePost(){
       //Todo enviar el beneficio
       $this->logger->info('Envía un beneficio');
   }

   public function sendGraduatePost(Graduate $graduate ){

       try {
           $userRecord=$this->auth->createUserWithEmailAndPassword($graduate->getEmail(), '123456');

//           $this->logger->info('UID');
//           $this->logger->info($userRecord->uid);
//           $this->logger->info('contraseña');
//           $this->logger->info($graduate->getPassword());
//           $this->logger->info('contraseña plana');
//           $this->logger->info($graduate->getPlainPassword());

       } catch (AuthException $e) {
           $this->logger->error($e->getMessage());
       } catch (FirebaseException $e) {
           $this->logger->error($e->getMessage());
       }

       //Todo enviar el graduado
        $this->logger->info('Envía un graduado');
   }





}
