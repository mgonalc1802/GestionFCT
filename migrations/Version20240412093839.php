<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412093839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Empresa ADD repres_id INT NOT NULL');
        $this->addSql('ALTER TABLE Empresa ADD CONSTRAINT FK_B8D75A50BB8DC6AE FOREIGN KEY (repres_id) REFERENCES representante (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B8D75A50BB8DC6AE ON Empresa (repres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Empresa DROP FOREIGN KEY FK_B8D75A50BB8DC6AE');
        $this->addSql('DROP INDEX UNIQ_B8D75A50BB8DC6AE ON Empresa');
        $this->addSql('ALTER TABLE Empresa DROP repres_id');
    }
}
