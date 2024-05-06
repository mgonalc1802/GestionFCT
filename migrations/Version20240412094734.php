<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412094734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actividad_formativo_productiva_criterio_evaluacion (actividad_formativo_productiva_id INT NOT NULL, criterio_evaluacion_id INT NOT NULL, INDEX IDX_4DA3FBD65AC29BC9 (actividad_formativo_productiva_id), INDEX IDX_4DA3FBD6815C58EA (criterio_evaluacion_id), PRIMARY KEY(actividad_formativo_productiva_id, criterio_evaluacion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actividad_formativo_productiva_criterio_evaluacion ADD CONSTRAINT FK_4DA3FBD65AC29BC9 FOREIGN KEY (actividad_formativo_productiva_id) REFERENCES actividad_formativo_productiva (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actividad_formativo_productiva_criterio_evaluacion ADD CONSTRAINT FK_4DA3FBD6815C58EA FOREIGN KEY (criterio_evaluacion_id) REFERENCES criterio_evaluacion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actividad_formativo_productiva_criterio_evaluacion DROP FOREIGN KEY FK_4DA3FBD65AC29BC9');
        $this->addSql('ALTER TABLE actividad_formativo_productiva_criterio_evaluacion DROP FOREIGN KEY FK_4DA3FBD6815C58EA');
        $this->addSql('DROP TABLE actividad_formativo_productiva_criterio_evaluacion');
    }
}
