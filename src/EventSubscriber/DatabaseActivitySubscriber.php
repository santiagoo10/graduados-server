<?php


namespace App\EventSubscriber;


use App\Entity\Graduate;
use App\Entity\Owner;
use App\Entity\Sale;
use App\Entity\Store;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Kreait\Firebase\Auth;
use Psr\Log\LoggerInterface;

class DatabaseActivitySubscriber implements EventSubscriber
{


    private LoggerInterface $logger;
    private Auth $auth;


    public function __construct(LoggerInterface $logger, Auth $auth)
    {
        $this->logger = $logger;
        $this->auth = $auth;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $this->logActivity('persist', $args);
    }


    private function logActivity(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof User) {
            return;
        }
        switch (true){
            case ($entity instanceof User):
                $roles= $entity->getRoles();
                switch (end($roles)){
                    case 'ROLE_USER':
                        $this->sendUserPost($entity);
                        break;
                    case 'ROLE_GRADUATE':
                        $this->sendGraduatePost($entity );
                        break;
                    case 'ROLE_OWNER':
                        $this->sendOwnerPost($entity );
                        break;
                }
                break;
            case ($entity instanceof Sale):
                $this->sendSalePost($entity);
                break;
            case ($entity instanceof Store):
                $this->sendStorePost($entity);
                break;
        }
    }


    public function sendStorePost(Store $store){
        //TODO aparentemente sólo guarda los benecificios en la db firestore. Por lo tanto acá no debería hacer nada

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

    public function sendOwnerPost(Owner $owner){
        if(empty($owner->getIdFirebase())){
            try {
                $userRecord=$this->auth->createUserWithEmailAndPassword($owner->getEmail(), '123456');
                $owner->setIdFirebase($userRecord->uid);
            } catch (AuthException $e) {
                $this->logger->error($e->getMessage());
            } catch (FirebaseException $e) {
                $this->logger->error($e->getMessage());
            }

        }
        $this->logger->info('Envía un owner');
    }

    public function sendGraduatePost(Graduate $graduate ){
        if(empty($graduate->getIdFirebase())){
            try {
                $userRecord=$this->auth->createUserWithEmailAndPassword($graduate->getEmail(), '123456');
                $graduate->setIdFirebase($userRecord->uid);
            } catch (AuthException $e) {
                $this->logger->error($e->getMessage());
            } catch (FirebaseException $e) {
                $this->logger->error($e->getMessage());
            }

        }
        //Todo enviar el graduado
        $this->logger->info('Envía un graduado');
    }

    public function sendUserPost(User $user){
        //Todo enviar el user
        $this->logger->info('Envía un usuario');

    }

}