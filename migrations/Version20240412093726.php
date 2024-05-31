<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412093726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Empresa ADD tutor_lab_id INT NOT NULL');
        $this->addSql('ALTER TABLE Empresa ADD CONSTRAINT FK_B8D75A5047375407 FOREIGN KEY (tutor_lab_id) REFERENCES tutor_laboral (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B8D75A5047375407 ON Empresa (tutor_lab_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Empresa DROP FOREIGN KEY FK_B8D75A5047375407');
        $this->addSql('DROP INDEX UNIQ_B8D75A5047375407 ON Empresa');
        $this->addSql('ALTER TABLE Empresa DROP tutor_lab_id');
    }
}
