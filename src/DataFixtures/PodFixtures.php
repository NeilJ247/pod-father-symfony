<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Job;
use App\Entity\JobType;
use App\Entity\Site;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class PodFixtures extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $csv = __DIR__ . '/pod-data.csv';

        $customers = [];
        $sites = [];

        $row = 1;
        if (($handle = fopen($csv, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($row == 1) {
                    $row++;
                    continue;
                }

                $customerName = $data[0];
                $siteName = $data[1];

                if (!isset($customers[$customerName])) {
                    $customers[$customerName] = $this->createCustomer($customerName);
                }

                if (!isset($sites[$siteName])) {
                    $sites[$siteName] = $this->createSite($siteName);
                }

                $job = $this->createJob(
                    $sites[$siteName],
                    JobType::tryFrom($data[4]),
                    (bool)$data[5],
                    (bool)$data[6],
                    $data[7],
                    $this->getDateTime($data[2]),
                    $this->getDateTime($data[3]),
                );

                $customers[$customerName]->addJob($job);
            }
            fclose($handle);
        }

        $manager->flush();
    }

    private function getDateTime(string $dateTime): DateTimeImmutable
    {
        return new DateTimeImmutable($dateTime, new \DateTimeZone('UTC'));
    }

    private function createCustomer(string $name): Customer
    {
        $customer = new Customer();
        $customer->setName($name);

        $this->manager->persist($customer);

        return $customer;
    }

    private function createSite(string $name): Site
    {
        $site = new Site();
        $site->setName($name);

        $this->manager->persist($site);

        return $site;
    }

    private function createJob(
        Site $site,
        JobType $jobType,
        bool $isLate,
        bool $isFlagged,
        int $numberOfItems,
        DateTimeImmutable $dueBy,
        DateTimeImmutable $completedAt,
    ): Job {
        $job = new Job();
        $job->setJobType($jobType);
        $job->setSite($site);
        $job->setLate($isLate);
        $job->setFlagged($isFlagged);
        $job->setNumberOfItems($numberOfItems);
        $job->setDueBy($dueBy);
        $job->setCompletedAt($completedAt);

        $this->manager->persist($job);

        return $job;
    }
}
