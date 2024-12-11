<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211222455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel ADD propietario_id INT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED953C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_3535ED953C8D32C ON hotel (propietario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED953C8D32C');
        $this->addSql('DROP INDEX IDX_3535ED953C8D32C ON hotel');
        $this->addSql('ALTER TABLE hotel DROP propietario_id');
    }
}
