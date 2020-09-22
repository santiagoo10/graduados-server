<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Graduate;
use App\Entity\Sale;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserCreatedSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
                        $this->sendUserPost();
                        break;
                    case 'ROLE_GRADUATE':
                        $this->sendGraduatePost();
                        break;
                }
                break;
            case ($value instanceof Sale):
                $this->sendSalePost();
                break;
        }
    }

    public function sendUserPost(){
        //Todo enviar el user
        $this->logger->info('Envía un usuario');

    }

   public function sendSalePost(){
       //Todo enviar el beneficio
       $this->logger->info('Envía un beneficio');
   }

   public function sendGraduatePost(){

       //Todo enviar el graduado
        $this->logger->info('Envía un graduado');
   }





}
