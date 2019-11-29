<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 28.11.19
 * Time: 10:23
 */

namespace App\Service\Helpers;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class SerializeService
 * @package App\Service\Helpers
 */
class SerializeService
{
    /**
     * Serialize object in order to send by api
     * @param $entity
     * @return string
     */
    public function serialize($entity): string
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($entity, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        //return $serializer->serialize($jsonObject, 'json');
    }
}