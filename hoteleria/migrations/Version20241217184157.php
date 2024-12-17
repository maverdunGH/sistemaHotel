<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217184157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitacion ADD hotel_id INT NOT NULL');
        $this->addSql('ALTER TABLE habitacion ADD CONSTRAINT FK_F45995BA3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('CREATE INDEX IDX_F45995BA3243BB18 ON habitacion (hotel_id)');
        $this->addSql('ALTER TABLE reserva ADD usuario_id INT NOT NULL, ADD habitacion_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BB009290D FOREIGN KEY (habitacion_id) REFERENCES habitacion (id)');
        $this->addSql('CREATE INDEX IDX_188D2E3BDB38439E ON reserva (usuario_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3BB009290D ON reserva (habitacion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BDB38439E');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BB009290D');
        $this->addSql('DROP INDEX IDX_188D2E3BDB38439E ON reserva');
        $this->addSql('DROP INDEX IDX_188D2E3BB009290D ON reserva');
        $this->addSql('ALTER TABLE reserva DROP usuario_id, DROP habitacion_id');
        $this->addSql('ALTER TABLE habitacion DROP FOREIGN KEY FK_F45995BA3243BB18');
        $this->addSql('DROP INDEX IDX_F45995BA3243BB18 ON habitacion');
        $this->addSql('ALTER TABLE habitacion DROP hotel_id');
    }
}
