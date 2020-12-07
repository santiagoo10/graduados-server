<?php


namespace App\DatePersister;



use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Sale;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

final class SaleDataPersister implements ContextAwareDataPersisterInterface
{
    private StoreRepository $storeRepository;
    private Security $security;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        StoreRepository $storeRepository
    )
    {
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
