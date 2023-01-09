<?php
declare(strict_types=1);

namespace App\Repository;

interface JobRepositoryInterface
{
    public function findByCustomerId(): array;

    public function findAllJobs(JobSearchCriteria $searchCriteria = null): array;
}
