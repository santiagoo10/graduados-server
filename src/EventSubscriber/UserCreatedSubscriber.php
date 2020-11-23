<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Graduate;
use App\Entity\Owner;
use App\Entity\Sale;
use App\Entity\Store;
use App\Entity\User;
use App\Repository\OwnerRepository;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Kreait\Firebase\Auth;
//use Doctrine\ORM\EntityManagerInterface;

class UserCreatedSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;
    private Auth $auth;
    private OwnerRepository $ownerRepository;
//    private EntityManagerInterface $entityManager;



    public function __construct(LoggerInterface $logger, Auth $auth, OwnerRepository $ownerRepository//,
//                                EntityManagerInterface $entityManager
    )
    {
        $this->logger = $logger;
        $this->auth = $auth;
        $this->ownerRepository =  $ownerRepository;
//        $this->entityManager = $entityManager;
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
                    case 'ROLE_OWNER':
                        $this->sendOwnerPost($value );
                        break;
                }
                break;
            case ($value instanceof Sale):
//                $this->sendSalePost($value);
                break;
            case ($value instanceof Store):
                $this->sendStorePost($value);
                break;
        }
    }

    public function sendOwnerPost(Owner $owner){
        if($owner->getIdFirebase()){
            try {
                $userRecord = $this->auth->createUserWithEmailAndPassword($owner->getEmail(), '123456');
                $owner->setUidFirebase($userRecord);
//                $this->entityManager->persist($owner);
//                $this->entityManager->flush();

            } catch (AuthException $e) {
            } catch (FirebaseException $e) {
            }

        }


    }

    public function sendStorePost(Store $store){
       //TODO aparentemente sólo guarda los benecificios en la db firestore. Por lo tanto acá no debería hacer nada

    }
    public function sendUserPost(User $user){
        //Todo enviar el user
        $this->logger->info('Envía un usuario');

    }

   public function sendSalePost( Sale $sale){
       $store = $sale->getStore();
       $storeAdress = $store->getAddress();
       $owner = $store->getOwner();
       $data = [
           'address' => $storeAdress->getStreet() . " " . $storeAdress->getNumber(),
//           'createdAt' => $sale->getCreatedAt()
//           'createdBy' => seguirrrrj

       ];

       //Todo enviar el beneficio
       $this->logger->info('Envía un beneficio');
   }

   public function sendGraduatePost(Graduate $graduate ){
        if(empty($graduate->getIdFirebase())){
            try {
                $userRecord=$this->auth->createUserWithEmailAndPassword($graduate->getEmail(), '123456');
                $graduate->setIdFirebase($userRecord);




            } catch (AuthException $e) {
                $this->logger->error($e->getMessage());
            } catch (FirebaseException $e) {
                $this->logger->error($e->getMessage());
            }

        }


       //Todo enviar el graduado
        $this->logger->info('Envía un graduado');
   }





}
