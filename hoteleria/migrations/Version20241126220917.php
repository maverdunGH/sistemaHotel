<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241126220917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP clave, DROP telefono, DROP nombre, DROP apellido, DROP nacionalidad, DROP direccion, DROP tipo, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON usuario (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON usuario');
        $this->addSql('ALTER TABLE usuario ADD clave VARCHAR(30) NOT NULL, ADD telefono VARCHAR(40) DEFAULT NULL, ADD nombre VARCHAR(150) NOT NULL, ADD apellido VARCHAR(150) NOT NULL, ADD nacionalidad VARCHAR(50) DEFAULT NULL, ADD direccion VARCHAR(100) DEFAULT NULL, ADD tipo VARCHAR(2) NOT NULL, DROP roles, DROP password, CHANGE email email VARCHAR(255) NOT NULL');
    }
}
