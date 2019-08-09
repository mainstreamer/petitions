<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\SerializerInterface;


class CSVConverterService
{
    private $serializer;

    private $resolver;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->resolver  = new OptionsResolver();
        $this->configureOptions($this->resolver);
    }

    public function convert(object $data, array $options): string
    {
        $this->resolver->resolve($options);
        $context = $this->filter($options);

//        dd(array_filter(
//            $options,
//            function($value, $key) { return $value; },
//            ARRAY_FILTER_USE_BOTH
//        ));
//        dd($options);

        return $this->serializer->serialize($data->petitions, 'csv', $context);

//        $response = new Response($this->serializer->serialize($data->petitions, 'csv',
//            array_keys(array_filter(
//                $options,
//                function($value, $key) { return $value; },
//                ARRAY_FILTER_USE_BOTH
//                ))));

//        return $response;

    }

    private function filter(array $array)
    {
        return array_keys(array_filter(
            $array,
            function($item) { return $item; }
        ));
    }

    private function configureOptions(OptionsResolver $resolver)
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
}
