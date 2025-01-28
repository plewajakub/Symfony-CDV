<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128191654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_me ALTER user_id DROP DEFAULT');
        $this->addSql('ALTER TABLE about_me ADD CONSTRAINT FK_C3EC2ECBA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C3EC2ECBA76ED395 ON about_me (user_id)');
        $this->addSql('ALTER TABLE invoice ALTER created DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE about_me DROP CONSTRAINT FK_C3EC2ECBA76ED395');
        $this->addSql('DROP INDEX IDX_C3EC2ECBA76ED395');
        $this->addSql('ALTER TABLE about_me ALTER user_id SET DEFAULT 0');
        $this->addSql('ALTER TABLE invoice ALTER created SET DEFAULT \'CURRENT_DATE\'');
    }
}
