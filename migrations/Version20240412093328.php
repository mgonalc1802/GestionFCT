<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412093328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centro_trabajo ADD localid_id INT NOT NULL');
        $this->addSql('ALTER TABLE centro_trabajo ADD CONSTRAINT FK_2099B9D11E7E849F FOREIGN KEY (localid_id) REFERENCES localidad (id)');
        $this->addSql('CREATE INDEX IDX_2099B9D11E7E849F ON centro_trabajo (localid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centro_trabajo DROP FOREIGN KEY FK_2099B9D11E7E849F');
        $this->addSql('DROP INDEX IDX_2099B9D11E7E849F ON centro_trabajo');
        $this->addSql('ALTER TABLE centro_trabajo DROP localid_id');
    }
}
