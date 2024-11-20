<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119235959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel ADD descripcion LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva ADD id_habitacion_id INT NOT NULL, ADD id_cliente_id INT NOT NULL, ADD id_hotel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BE21F868 FOREIGN KEY (id_habitacion_id) REFERENCES habitacion (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B7BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES usuario (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_188D2E3BE21F868 ON reserva (id_habitacion_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_188D2E3B7BF9CE86 ON reserva (id_cliente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP descripcion');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BE21F868');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B7BF9CE86');
        $this->addSql('DROP INDEX UNIQ_188D2E3BE21F868 ON reserva');
        $this->addSql('DROP INDEX UNIQ_188D2E3B7BF9CE86 ON reserva');
        $this->addSql('ALTER TABLE reserva DROP id_habitacion_id, DROP id_cliente_id, DROP id_hotel');
    }
}
