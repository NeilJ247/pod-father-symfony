<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106140859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates an enum field for job types';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TYPE job_type_enum AS ENUM (\'Delivery\', \'Collection\');'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'DROP TYPE IF EXISTS job_type_enum'
        );
    }
}
