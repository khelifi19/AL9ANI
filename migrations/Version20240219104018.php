<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219104018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, ville VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, chauffeur_id INT NOT NULL, modele VARCHAR(255) NOT NULL, nb_place INT NOT NULL, disponibilite TINYINT(1) NOT NULL, matricule VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E9E2810F12B2DC9C (matricule), INDEX IDX_E9E2810F85C0B3BE (chauffeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F85C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
        $this->addSql('ALTER TABLE course DROP prix, DROP statut, DROP duree, CHANGE date_course date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A40B286D FOREIGN KEY (id_voiture_id) REFERENCES voiture (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9A40B286D');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F85C0B3BE');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('ALTER TABLE course ADD prix DOUBLE PRECISION NOT NULL, ADD statut TINYINT(1) NOT NULL, ADD duree INT NOT NULL, CHANGE date date_course DATETIME NOT NULL');
    }
}
