<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412094245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convenio ADD programa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE convenio ADD CONSTRAINT FK_25577244FD8A7328 FOREIGN KEY (programa_id) REFERENCES programa_formativo (id)');
        $this->addSql('CREATE INDEX IDX_25577244FD8A7328 ON convenio (programa_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convenio DROP FOREIGN KEY FK_25577244FD8A7328');
        $this->addSql('DROP INDEX IDX_25577244FD8A7328 ON convenio');
        $this->addSql('ALTER TABLE convenio DROP programa_id');
    }
}
