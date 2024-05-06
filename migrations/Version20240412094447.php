<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412094447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE programa_formativo_actividad_formativo_productiva (programa_formativo_id INT NOT NULL, actividad_formativo_productiva_id INT NOT NULL, INDEX IDX_BA61AE311813D9BD (programa_formativo_id), INDEX IDX_BA61AE315AC29BC9 (actividad_formativo_productiva_id), PRIMARY KEY(programa_formativo_id, actividad_formativo_productiva_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE programa_formativo_actividad_formativo_productiva ADD CONSTRAINT FK_BA61AE311813D9BD FOREIGN KEY (programa_formativo_id) REFERENCES programa_formativo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programa_formativo_actividad_formativo_productiva ADD CONSTRAINT FK_BA61AE315AC29BC9 FOREIGN KEY (actividad_formativo_productiva_id) REFERENCES actividad_formativo_productiva (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programa_formativo_actividad_formativo_productiva DROP FOREIGN KEY FK_BA61AE311813D9BD');
        $this->addSql('ALTER TABLE programa_formativo_actividad_formativo_productiva DROP FOREIGN KEY FK_BA61AE315AC29BC9');
        $this->addSql('DROP TABLE programa_formativo_actividad_formativo_productiva');
    }
}
