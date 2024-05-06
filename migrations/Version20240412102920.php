<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412102920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_convenio (user_id INT NOT NULL, convenio_id INT NOT NULL, INDEX IDX_C5DA9644A76ED395 (user_id), INDEX IDX_C5DA9644F9D43F2A (convenio_id), PRIMARY KEY(user_id, convenio_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_convenio ADD CONSTRAINT FK_C5DA9644A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_convenio ADD CONSTRAINT FK_C5DA9644F9D43F2A FOREIGN KEY (convenio_id) REFERENCES convenio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD alumno_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FC28E5EE FOREIGN KEY (alumno_id) REFERENCES convenio (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649FC28E5EE ON user (alumno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_convenio DROP FOREIGN KEY FK_C5DA9644A76ED395');
        $this->addSql('ALTER TABLE user_convenio DROP FOREIGN KEY FK_C5DA9644F9D43F2A');
        $this->addSql('DROP TABLE user_convenio');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FC28E5EE');
        $this->addSql('DROP INDEX IDX_8D93D649FC28E5EE ON user');
        $this->addSql('ALTER TABLE user DROP alumno_id');
    }
}
