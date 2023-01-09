<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\JobSearchCriteria;
use Symfony\Component\HttpFoundation\Request;

class JobFilterResolver
{
    public static function resolve(Request $request): JobSearchCriteria
    {
        $searchCriteria = new JobSearchCriteria();

        if ($filters = $request->get('filters')) {
            foreach ($filters as $field => $filter) {
                $operator = key($filter);
                $value = $filter[$operator];
                $searchCriteria->add($field, $operator, $value);
            }
        }

        return $searchCriteria;
    }
}
