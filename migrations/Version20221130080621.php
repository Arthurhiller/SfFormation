<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130080621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP nb_place_reserve, DROP nb_place_disponible');
        $this->addSql('ALTER TABLE stagiaire CHANGE sexe sexe VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session ADD nb_place_reserve INT DEFAULT NULL, ADD nb_place_disponible INT NOT NULL');
        $this->addSql('ALTER TABLE stagiaire CHANGE sexe sexe VARCHAR(255) NOT NULL');
    }
}
