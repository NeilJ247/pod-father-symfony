<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\JobRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route('/jobs', name: 'jobs_list')]
    public function index(Request $request, JobRepositoryInterface $jobRepository): Response
    {
        $searchCriteria = JobFilterResolver::resolve($request);

        // TODO create a serializer so we can transform to different formats based on request headers
        $results = $jobRepository->findAllJobs($searchCriteria);

        return $this->json($results);
    }
}
