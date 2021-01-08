<?php


namespace App\Controller;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Vich\UploaderBundle\Storage\StorageInterface;
use Kreait\Firebase\Storage;


final class CreateMediaObjectAction
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var StorageInterface
     */
    private StorageInterface $storage;
    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;
    /**
     * @var Storage
     */
    private Storage $kstorage;

    public function __construct(EntityManagerInterface $entityManager,
                                StorageInterface $storage,
                                ParameterBagInterface $parameterBag,
                                Storage $kstorage
    ){
        $this->entityManager = $entityManager;
        $this->storage = $storage;
        $this->parameterBag = $parameterBag;
        $this->kstorage = $kstorage;
    }

    public function __invoke(Request $request): MediaObject
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }


        //create the image instance
        $mediaObject = new MediaObject();


        $mediaObject->file = $uploadedFile;

//        $this->entityManager->persist($mediaObject);
//        $this->entityManager->flush();

//        $contentUrl = $this->storage->resolveUri($mediaObject,'file');

//        $raiz = $this->parameterBag->get('kernel.project_dir');
//        $path = $raiz .  '/public' . $contentUrl;
//        $imagedata = file_get_contents($path);
//        $base64 = base64_encode($imagedata);
//        $bucket = $this->kstorage->getBucket('sale-images');
//        $bucket = $this->kstorage->getBucket('sale-images');
//        $bucket = $this->kstorage->getBucket('graduados-a7240.appspot.com/sale-images');
//        $bucket = $this->kstorage->getBucket();


//        $key = base64_encode(openssl_random_pseudo_bytes(32));
//        $bucket->upload($base64, ['name' => $mediaObject->getId(), 'encryptionKey' => $key]);











        return $mediaObject;
    }
}
