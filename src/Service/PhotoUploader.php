<?php

namespace App\Service;

use App\Contract\UploadInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class PhotoUploader
{
    private string $targetFolder;

    private FlashBagInterface $flashbag;

    /**
     * @param string $targetFolder
     * @param RequestStack $requestStack
     */
    public function __construct(string $targetFolder, RequestStack $requestStack)
    {
        $this->targetFolder = $targetFolder;
        $this->flashbag = $requestStack->getCurrentRequest()->getSession()->getFlashBag();
    }


    public function upload(UploadInterface $entity): void{
        $upload = $entity->getUploadedFile();
        if($upload){
            // Création d'un nom de fichier unique
            $fileName = uniqid('photo_', true)
                .'.'. $upload->guessExtension();

            try {
                $upload->move(
                    $this->targetFolder,
                    $fileName
                );
                $entity->setImageFileName($fileName);
                $this->flashbag->add('success', 'La photo est téléchargée');
            } catch (FileException $ex){
                $this->flashbag->add('error', 'Impossible de charger cette image');
            }
        }
    }

}