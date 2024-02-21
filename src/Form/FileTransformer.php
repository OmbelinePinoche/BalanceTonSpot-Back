<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileTransformer implements DataTransformerInterface
{
    public function transform($value): mixed
    {
        // transform the File to a string (file path)
        if ($value instanceof File) {
            return $value->getPathname();
        }
        return null;
    }

    public function reverseTransform($value): mixed
    {
        // transform the string (file path) to a File instance
        if (!empty($value)) {
            // Use UploadedFile instead of File to keep the file upload information
            return new UploadedFile($value, 'original_filename', null, null, true);
        }
        return null;
    }
}

