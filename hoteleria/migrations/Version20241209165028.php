<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209165028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED96EAE6E2A');
        $this->addSql('DROP INDEX IDX_3535ED96EAE6E2A ON hotel');
        $this->addSql('ALTER TABLE hotel DROP id_propietario_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel ADD id_propietario_id INT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED96EAE6E2A FOREIGN KEY (id_propietario_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3535ED96EAE6E2A ON hotel (id_propietario_id)');
    }
}
