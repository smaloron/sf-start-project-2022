<?php

namespace App\Contract;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadInterface
{

    public function getUploadedFile(): ?UploadedFile;

    public function getImageFileName(): ?string;

    public function setImageFileName(string $imageFileName): self;


}