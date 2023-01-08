<?php
declare(strict_types=1);

namespace App\Entity;

enum JobType: string
{
    case Collection = 'Collection';
    case Delivery = 'Delivery';
}
