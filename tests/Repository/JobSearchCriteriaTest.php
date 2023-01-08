<?php
declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\JobSearchCriteria;
use PHPUnit\Framework\TestCase;

class JobSearchCriteriaTest extends TestCase
{
    private JobSearchCriteria $subject;
    protected function setUp(): void
    {
        $this->subject = new JobSearchCriteria();
    }

    /**
     * @test
     * @return void
     * @throws \Exception
     */
    public function it_should_only_allow_valid_search_fields(): void
    {
        // Arrange
        $this->expectExceptionMessage('Invalid search field cancelled_at');

        // Act
        $this->subject->add('cancelled_at', '=', 'SOME_DATE');
    }

    /**
     * @test
     * @return void
     * @throws \Exception
     */
    public function it_should_only_allow_valid_search_operators(): void
    {
        // Arrange
        $this->expectExceptionMessage('Invalid search operator -');

        // Act
        $this->subject->add('due_by', '-', 'SOME_DATE');
    }

    /**
     * @test
     * @return void
     * @throws \Exception
     */
    public function it_should_not_allow_duplicate_fields(): void
    {
        // Arrange
        $this->expectExceptionMessage('Cannot search a field more than once');

        // Act
        $this->subject->add('due_by', 'eq', 'SOME_DATE');
        $this->subject->add('due_by', 'lt', 'SOME_DATE');
    }

    /**
     * @test
     * @return void
     * @throws \Exception
     */
    public function it_should_get_criteria(): void
    {
        // Arrange
        $expected = [
            'j.due_by' => [
                '=' => 'SOME_DATE',
            ],
            'c.name' => [
                '=' => 'Acme Ltd'
            ]
        ];

        $this->subject
            ->add('due_by', 'eq', 'SOME_DATE')
            ->add('customer', 'eq', 'Acme Ltd');

        // Act
        $result = $this->subject->getCriterias();

        // Assert
        $this->assertEquals($expected, $result);
    }
}
