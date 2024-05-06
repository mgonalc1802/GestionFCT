<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412094151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convenio ADD tutor_lab_id INT NOT NULL');
        $this->addSql('ALTER TABLE convenio ADD CONSTRAINT FK_2557724447375407 FOREIGN KEY (tutor_lab_id) REFERENCES tutor_laboral (id)');
        $this->addSql('CREATE INDEX IDX_2557724447375407 ON convenio (tutor_lab_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convenio DROP FOREIGN KEY FK_2557724447375407');
        $this->addSql('DROP INDEX IDX_2557724447375407 ON convenio');
        $this->addSql('ALTER TABLE convenio DROP tutor_lab_id');
    }
}
