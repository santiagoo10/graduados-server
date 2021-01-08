<?php


namespace App\DatePersister;



use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Sale;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Kreait\Firebase\Exception\DatabaseException;
use Symfony\Component\Security\Core\Security;
use Kreait\Firebase\Database;

final class SaleDataPersister implements ContextAwareDataPersisterInterface
{
    private Database $db;
    private StoreRepository $storeRepository;
    private Security $security;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        Database $db,
        EntityManagerInterface $entityManager,
        Security $security,
        StoreRepository $storeRepository
    )
    {
        $this->db = $db;
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->storeRepository = $storeRepository;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Sale;
    }

    /**
     * @param Sale $data
     * @param array $context
     * @return object|void
     * @throws Exception
     */
    public function persist($data, array $context = [])
    {

        $user = $this->security->getUser();
        if($this->security->isGranted('ROLE_ADMIN')){
            //TODO firebase para admin

        }else{

            $store = $this->storeRepository->findOneBy(['owner' => $user]);
            $data->setStore($store);


            //TODO firebase para owner
        }


        $storeData = $data->getStore();
        $street = $storeData->getAddress()->getStreet();
        $streetNumber= $storeData->getAddress()->getName();
        $latitude = $storeData->getAddress()->getLatitude();
        $longitude = $storeData->getAddress()->getLongitude();
        $storeOwner = $storeData->getOwner();
        $createAt =  new \DateTime();
        $dataFirebase= [
            'address' => $street . " " . $streetNumber,
            'createAt'=> $createAt->format('dd-MM-yyyy'),
            'createBy'=> $storeOwner->getIdFirebase(),
            'description'=>$data->getDescription(),
            'images'=> null,
            'location'=> [
                'latitude'=> $latitude,
                'latitudeDelta'=> null,
                'longitude' => $longitude,
                'longitudeDelta'=> null,
            ],
            'name'=> $data->getName(),
            'store'=> [
                'email'=> $storeOwner->getEmail(),
                'name' => $storeData->getName(),
                'phone' => $storeData->getPhone()
            ]
        ];

        $random = bin2hex(random_bytes(4));
        $path = '/sales/' . $random;
        //Esto hay que hacerlo con un post, es un api!
//        $idFirebase =$this->db->getReference($path)->set($dataFirebase);

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

}
