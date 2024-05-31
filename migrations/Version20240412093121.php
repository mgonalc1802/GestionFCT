<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412093121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE convenio (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Localidad ADD provi_id INT NOT NULL');
        $this->addSql('ALTER TABLE Localidad ADD CONSTRAINT FK_4F68E010E29B83B0 FOREIGN KEY (provi_id) REFERENCES provincia (id)');
        $this->addSql('CREATE INDEX IDX_4F68E010E29B83B0 ON Localidad (provi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE convenio');
        $this->addSql('ALTER TABLE Localidad DROP FOREIGN KEY FK_4F68E010E29B83B0');
        $this->addSql('DROP INDEX IDX_4F68E010E29B83B0 ON Localidad');
        $this->addSql('ALTER TABLE Localidad DROP provi_id');
    }
}
