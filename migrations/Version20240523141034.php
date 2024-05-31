<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523141034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Empresa ADD familia_profesional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Empresa ADD CONSTRAINT FK_B8D75A50CBF1FCC FOREIGN KEY (familia_profesional_id) REFERENCES familia_profesional (id)');
        $this->addSql('CREATE INDEX IDX_B8D75A50CBF1FCC ON Empresa (familia_profesional_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Empresa DROP FOREIGN KEY FK_B8D75A50CBF1FCC');
        $this->addSql('DROP INDEX IDX_B8D75A50CBF1FCC ON Empresa');
        $this->addSql('ALTER TABLE Empresa DROP familia_profesional_id');
    }
}
