<?php


namespace App\Controller;

use App\Entity\MediaObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


final class CreateMediaObjectAction
{

    public function __invoke(Request $request): MediaObject
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }


        //create the image instance
        $mediaObject = new MediaObject();


        $mediaObject->file = $uploadedFile;

        //Probablemente acá tenga que encodearlo y guardarlo en la variable


        return $mediaObject;
    }
}
