<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250115144157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_DATE');
        $this->addSql('ALTER TABLE invoice ADD email VARCHAR(35) DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice ADD phone VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE invoice DROP updated');
        $this->addSql('ALTER TABLE invoice DROP email');
        $this->addSql('ALTER TABLE invoice DROP phone');
    }
}
