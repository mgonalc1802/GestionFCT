<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412093624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empresa ADD localid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE empresa ADD CONSTRAINT FK_B8D75A501E7E849F FOREIGN KEY (localid_id) REFERENCES localidad (id)');
        $this->addSql('CREATE INDEX IDX_B8D75A501E7E849F ON empresa (localid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empresa DROP FOREIGN KEY FK_B8D75A501E7E849F');
        $this->addSql('DROP INDEX IDX_B8D75A501E7E849F ON empresa');
        $this->addSql('ALTER TABLE empresa DROP localid_id');
    }
}
