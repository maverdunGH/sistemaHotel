<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119231006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario ADD email VARCHAR(255) NOT NULL, ADD telefono VARCHAR(40) DEFAULT NULL, ADD nombre VARCHAR(150) NOT NULL, ADD apellido VARCHAR(150) NOT NULL, ADD nacionalidad VARCHAR(50) DEFAULT NULL, ADD direccion VARCHAR(100) DEFAULT NULL, ADD tipo VARCHAR(2) NOT NULL, DROP usuario');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario ADD usuario VARCHAR(30) NOT NULL, DROP email, DROP telefono, DROP nombre, DROP apellido, DROP nacionalidad, DROP direccion, DROP tipo');
    }
}
