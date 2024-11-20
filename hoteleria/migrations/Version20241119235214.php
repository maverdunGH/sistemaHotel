<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119235214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitacion (id INT AUTO_INCREMENT NOT NULL, id_hotel_id INT NOT NULL, numero INT NOT NULL, cant_personas INT NOT NULL, precio_noche DOUBLE PRECISION NOT NULL, INDEX IDX_F45995BA6298578D (id_hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, direccion VARCHAR(100) NOT NULL, telefono VARCHAR(100) NOT NULL, pais VARCHAR(50) NOT NULL, ciudad VARCHAR(50) NOT NULL, cant_estrellas INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resea (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, id_hotel_id INT NOT NULL, calificacion INT NOT NULL, comentario LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_3D405BA67BF9CE86 (id_cliente_id), UNIQUE INDEX UNIQ_3D405BA66298578D (id_hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habitacion ADD CONSTRAINT FK_F45995BA6298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE resea ADD CONSTRAINT FK_3D405BA67BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE resea ADD CONSTRAINT FK_3D405BA66298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitacion DROP FOREIGN KEY FK_F45995BA6298578D');
        $this->addSql('ALTER TABLE resea DROP FOREIGN KEY FK_3D405BA67BF9CE86');
        $this->addSql('ALTER TABLE resea DROP FOREIGN KEY FK_3D405BA66298578D');
        $this->addSql('DROP TABLE habitacion');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE resea');
    }
}
