<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128194707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE company_data_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_data_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE information_about_me_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE about_me_id_seq CASCADE');
        $this->addSql('DROP TABLE user_data');
        $this->addSql('DROP TABLE company_data');
        $this->addSql('DROP TABLE about_me');
        $this->addSql('DROP TABLE information_about_me');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE company_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE information_about_me_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE about_me_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_data (id SERIAL NOT NULL, name VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE company_data (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, street_number VARCHAR(255) NOT NULL, flat_number VARCHAR(10) DEFAULT NULL, post_code VARCHAR(10) NOT NULL, city VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, phone VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE about_me (id SERIAL NOT NULL, key VARCHAR(50) NOT NULL, value VARCHAR(1000) NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE information_about_me (id SERIAL NOT NULL, key VARCHAR(20) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }
}
