<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220012314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id_event INT AUTO_INCREMENT NOT NULL, nom_event VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, type_event VARCHAR(255) NOT NULL, nbr_participants INT NOT NULL, PRIMARY KEY(id_event)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pass (id_pass INT AUTO_INCREMENT NOT NULL, id_event INT DEFAULT NULL, prix_pass INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_CE70D424D52B4B97 (id_event), PRIMARY KEY(id_pass)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D424D52B4B97 FOREIGN KEY (id_event) REFERENCES evenement (idEvent)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pass DROP FOREIGN KEY FK_CE70D424D52B4B97');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE pass');
    }
}
