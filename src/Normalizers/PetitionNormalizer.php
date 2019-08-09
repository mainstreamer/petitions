<?php

namespace App\Normalizers;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PetitionNormalizer implements NormalizerInterface
{

    public function normalize($data, $format = null, array $context = [])
    {
        $data = array_filter((array) $data, function($value, $key) use ($context) {
            return in_array($key, $context);
        }, ARRAY_FILTER_USE_BOTH);

        return $data;
    }


    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof \stdClass;
    }
}
