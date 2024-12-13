<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213154108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED953C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_3535ED953C8D32C ON hotel (propietario_id)');
        $this->addSql('ALTER TABLE resenia ADD relacion_reserva_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resenia ADD CONSTRAINT FK_C0EB7AB1E30273A4 FOREIGN KEY (relacion_reserva_id) REFERENCES reserva (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0EB7AB1E30273A4 ON resenia (relacion_reserva_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED953C8D32C');
        $this->addSql('DROP INDEX IDX_3535ED953C8D32C ON hotel');
        $this->addSql('ALTER TABLE resenia DROP FOREIGN KEY FK_C0EB7AB1E30273A4');
        $this->addSql('DROP INDEX UNIQ_C0EB7AB1E30273A4 ON resenia');
        $this->addSql('ALTER TABLE resenia DROP relacion_reserva_id');
    }
}
