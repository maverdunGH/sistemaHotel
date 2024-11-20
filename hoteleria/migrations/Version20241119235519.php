<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119235519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resenia (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, id_hotel_id INT NOT NULL, calificacion INT NOT NULL, comentario LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_C0EB7AB17BF9CE86 (id_cliente_id), UNIQUE INDEX UNIQ_C0EB7AB16298578D (id_hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resenia ADD CONSTRAINT FK_C0EB7AB17BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE resenia ADD CONSTRAINT FK_C0EB7AB16298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE resea DROP FOREIGN KEY FK_3D405BA67BF9CE86');
        $this->addSql('ALTER TABLE resea DROP FOREIGN KEY FK_3D405BA66298578D');
        $this->addSql('DROP TABLE resea');
        $this->addSql('ALTER TABLE reserva DROP id_habitacion, DROP id_cliente');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resea (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, id_hotel_id INT NOT NULL, calificacion INT NOT NULL, comentario LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_3D405BA67BF9CE86 (id_cliente_id), UNIQUE INDEX UNIQ_3D405BA66298578D (id_hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE resea ADD CONSTRAINT FK_3D405BA67BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE resea ADD CONSTRAINT FK_3D405BA66298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE resenia DROP FOREIGN KEY FK_C0EB7AB17BF9CE86');
        $this->addSql('ALTER TABLE resenia DROP FOREIGN KEY FK_C0EB7AB16298578D');
        $this->addSql('DROP TABLE resenia');
        $this->addSql('ALTER TABLE reserva ADD id_habitacion INT NOT NULL, ADD id_cliente INT NOT NULL');
    }
}
