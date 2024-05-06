<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412094057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convenio ADD centro_trab_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE convenio ADD CONSTRAINT FK_25577244B293FB00 FOREIGN KEY (centro_trab_id) REFERENCES centro_trabajo (id)');
        $this->addSql('CREATE INDEX IDX_25577244B293FB00 ON convenio (centro_trab_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convenio DROP FOREIGN KEY FK_25577244B293FB00');
        $this->addSql('DROP INDEX IDX_25577244B293FB00 ON convenio');
        $this->addSql('ALTER TABLE convenio DROP centro_trab_id');
    }
}
