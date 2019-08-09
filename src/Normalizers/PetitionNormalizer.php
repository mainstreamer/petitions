<?php

namespace App\Normalizers;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PetitionNormalizer implements NormalizerInterface
{
    private $resolver;

    public function __construct()
    {
        $this->resolver = new OptionsResolver();
        $this->configureOptions($this->resolver);
    }

    public function normalize($data, $format = null, array $context = []): array
    {
        $this->resolver->resolve($context);
        $context = $this->filter($context);

        $data = array_filter((array) $data, function($value, $key) use ($context) {
            return in_array($key, $context);
        }, ARRAY_FILTER_USE_BOTH);

        return $data;
    }

    private function filter(array $array): array
    {
        return array_keys(array_filter(
            $array,
            function($item) { return $item; }
        ));
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined([
            'title',
            'petitionID',
            'link',
            'signature_count',
            'summary',
            'description',
        ]);
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof \stdClass;
    }
}
