<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;


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
            return new File($value);
        }
        return null;
    }
}

