<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106142808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial database schema';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (customer_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(customer_id))');
        $this->addSql('CREATE TABLE job (job_id UUID NOT NULL, job_type job_type_enum, customer_id UUID NOT NULL, site_id UUID NOT NULL, due_by TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, late BOOLEAN NOT NULL, flagged BOOLEAN NOT NULL, number_of_items INT NOT NULL, PRIMARY KEY(job_id))');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8B171EB6C ON job (customer_id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8F6BD1646 ON job (site_id)');
        $this->addSql('COMMENT ON COLUMN job.due_by IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN job.completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE site (site_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(site_id))');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8B171EB6C FOREIGN KEY (customer_id) REFERENCES customer (customer_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8F6BD1646 FOREIGN KEY (site_id) REFERENCES site (site_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job DROP CONSTRAINT FK_FBD8E0F8B171EB6C');
        $this->addSql('ALTER TABLE job DROP CONSTRAINT FK_FBD8E0F8F6BD1646');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE site');
    }
}
