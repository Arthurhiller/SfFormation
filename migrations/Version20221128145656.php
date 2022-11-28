<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128145656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module_programme (module_id INT NOT NULL, programme_id INT NOT NULL, INDEX IDX_67BDA637AFC2B591 (module_id), INDEX IDX_67BDA63762BB7AEE (programme_id), PRIMARY KEY(module_id, programme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, nb_jour INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_programme (session_id INT NOT NULL, programme_id INT NOT NULL, INDEX IDX_7E3EFCF5613FECDF (session_id), INDEX IDX_7E3EFCF562BB7AEE (programme_id), PRIMARY KEY(session_id, programme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_session (user_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_8849CBDEA76ED395 (user_id), INDEX IDX_8849CBDE613FECDF (session_id), PRIMARY KEY(user_id, session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module_programme ADD CONSTRAINT FK_67BDA637AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_programme ADD CONSTRAINT FK_67BDA63762BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_programme ADD CONSTRAINT FK_7E3EFCF5613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_programme ADD CONSTRAINT FK_7E3EFCF562BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDE613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_C242628BCF5E72D ON module (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_programme DROP FOREIGN KEY FK_67BDA637AFC2B591');
        $this->addSql('ALTER TABLE module_programme DROP FOREIGN KEY FK_67BDA63762BB7AEE');
        $this->addSql('ALTER TABLE session_programme DROP FOREIGN KEY FK_7E3EFCF5613FECDF');
        $this->addSql('ALTER TABLE session_programme DROP FOREIGN KEY FK_7E3EFCF562BB7AEE');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDEA76ED395');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDE613FECDF');
        $this->addSql('DROP TABLE module_programme');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE session_programme');
        $this->addSql('DROP TABLE user_session');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628BCF5E72D');
        $this->addSql('DROP INDEX IDX_C242628BCF5E72D ON module');
        $this->addSql('ALTER TABLE module DROP categorie_id');
    }
}
