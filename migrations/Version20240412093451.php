<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412093451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE empresa_centro_trabajo (empresa_id INT NOT NULL, centro_trabajo_id INT NOT NULL, INDEX IDX_21342A4E521E1991 (empresa_id), INDEX IDX_21342A4E56DEA406 (centro_trabajo_id), PRIMARY KEY(empresa_id, centro_trabajo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE empresa_centro_trabajo ADD CONSTRAINT FK_21342A4E521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE empresa_centro_trabajo ADD CONSTRAINT FK_21342A4E56DEA406 FOREIGN KEY (centro_trabajo_id) REFERENCES centro_trabajo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empresa_centro_trabajo DROP FOREIGN KEY FK_21342A4E521E1991');
        $this->addSql('ALTER TABLE empresa_centro_trabajo DROP FOREIGN KEY FK_21342A4E56DEA406');
        $this->addSql('DROP TABLE empresa_centro_trabajo');
    }
}
