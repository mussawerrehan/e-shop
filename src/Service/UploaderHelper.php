<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    private $uploadsPath;

    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }
    public function uploadShopIcon(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath.'/shop_image';

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $originalFilename
        );
        return $originalFilename;
    }
}