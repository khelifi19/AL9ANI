<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240210205748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, id_voiture_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, statut TINYINT(1) NOT NULL, destination VARCHAR(255) NOT NULL, depart VARCHAR(255) NOT NULL, date_course DATETIME NOT NULL, nb_personne INT NOT NULL, duree INT NOT NULL, INDEX IDX_169E6FB9A40B286D (id_voiture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, modele VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, nb_place INT NOT NULL, disponibilite TINYINT(1) NOT NULL, matricule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A40B286D FOREIGN KEY (id_voiture_id) REFERENCES voiture (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9A40B286D');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE voiture');
    }
}
