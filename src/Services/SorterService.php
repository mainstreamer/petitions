<?php

namespace App\Services;

use \DateTime;

class SorterService
{
    public function sort(array $data): array
    {
        usort($data, function ($a,$b) {
            return -(new DateTime($a->stopdate) <=> new DateTime($b->stopdate));
        });

        return $data;
    }
}
