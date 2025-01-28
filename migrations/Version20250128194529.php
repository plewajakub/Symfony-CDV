<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128194529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE invoice_id_seq CASCADE');
        $this->addSql('DROP TABLE invoice');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE invoice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE invoice (id SERIAL NOT NULL, company_name VARCHAR(255) NOT NULL, company_street VARCHAR(100) NOT NULL, company_street_number VARCHAR(10) NOT NULL, company_street_flat_number VARCHAR(10) DEFAULT NULL, company_city VARCHAR(100) NOT NULL, company_post_code VARCHAR(10) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(35) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, tax_number VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
    }
}
