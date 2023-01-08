<?php
declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Job;
use App\Repository\JobRepositoryInterface;
use App\Repository\JobSearchCriteria;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JobRepositoryTest extends KernelTestCase
{
    private ?JobRepositoryInterface $subject;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->subject = $container->get(JobRepositoryInterface::class);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_return_all_jobs(): void
    {
        // Nothing to arrange

        // Act
        $results = $this->subject->findAllJobs();

        // Assert
        $this->assertCount(40, $results);
    }

    /**
     * @test
     * @return void
     * @throws \Exception
     */
    public function it_should_filter_all_jobs_on_customer_name(): void
    {
        // Arrange
        $customerName = 'Olive Grove Ltd';
        $criteria = new JobSearchCriteria();
        $criteria->add('customer', 'eq', $customerName);

        // Act
        $results = $this->subject->findAllJobs($criteria);

        // Assert
        $this->assertCount(12, $results);
        /** @var Job $job */
        foreach ($results as $job) {
            $this->assertEquals($customerName, $job->getCustomer()->getName());
        }
    }

    /**
     * @test
     * @return void
     * @throws \Exception
     */
    public function it_should_filter_all_jobs_on_more_than_one_field(): void
    {
        // Arrange
        $customerName = 'Fox Pubs Ltd';
        $criteria = new JobSearchCriteria();
        $criteria->add('customer', 'eq', $customerName)
            ->add('number_of_items', 'lteq', '100');

        // Act
        $results = $this->subject->findAllJobs($criteria);

        // Assert
        $this->assertCount(10, $results);
        /** @var Job $job */
        foreach ($results as $job) {
            $this->assertEquals($customerName, $job->getCustomer()->getName());
            $this->assertLessThanOrEqual(100, $job->getNumberOfItems());
        }
    }

    // TODO add more test cases
}
