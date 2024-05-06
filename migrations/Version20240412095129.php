<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412095129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE periodo ADD cursos_id INT NOT NULL');
        $this->addSql('ALTER TABLE periodo ADD CONSTRAINT FK_7316C4ED6AFE7B9A FOREIGN KEY (cursos_id) REFERENCES curso_escolar (id)');
        $this->addSql('CREATE INDEX IDX_7316C4ED6AFE7B9A ON periodo (cursos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE periodo DROP FOREIGN KEY FK_7316C4ED6AFE7B9A');
        $this->addSql('DROP INDEX IDX_7316C4ED6AFE7B9A ON periodo');
        $this->addSql('ALTER TABLE periodo DROP cursos_id');
    }
}
