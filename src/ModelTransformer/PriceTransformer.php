<?php
namespace App\ModelTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class PriceTransformer implements DataTransformerInterface
{
    public function transform(mixed $value)
    {
        return $value / 100;
    }
    public function reverseTransform(mixed $value)
    {
        return $value * 100;
    }
}