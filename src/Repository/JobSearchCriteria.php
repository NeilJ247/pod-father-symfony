<?php
declare(strict_types=1);

namespace App\Repository;

class JobSearchCriteria
{
    private const ALLOWED_OPERATORS = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'gteq' => '>=',
        'lteq' => '<=',
    ];

    private const ALLOWED_FIELDS = [
        'number_of_items' => 'j.number_of_items',
        'job_type' => 'j.job_type',
        'late' => 'j.late',
        'flagged' => 'j.flagged',
        'due_by' => 'j.due_by',
        'completed_at' => 'j.completed_at',
        'customer' => 'c.name',
        'site' => 's.name',
    ];

    private array $criterias = [];

    public function add(string $field, string $operator, string $value): self
    {
        // TODO create new Exceptions to provide context
        if (!in_array($field, array_keys(static::ALLOWED_FIELDS))) {
            throw new \Exception('Invalid search field ' . $field);
        }

        if (!in_array($operator, array_keys(static::ALLOWED_OPERATORS))) {
            throw new \Exception('Invalid search operator ' . $operator);
        }

        $fieldName = self::ALLOWED_FIELDS[$field];

        if (isset($this->criterias[$fieldName])) {
            throw new \Exception('Cannot search a field more than once');
        }

        $this->criterias[$fieldName] = [
            self::ALLOWED_OPERATORS[$operator] => $value
        ];

        return $this;
    }

    public function getCriterias(): array
    {
        return $this->criterias;
    }
}
