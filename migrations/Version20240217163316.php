<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217163316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955FF631228');
        $this->addSql('DROP INDEX IDX_42C84955FF631228 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP heure_reservation, CHANGE date_reservation date_reservation DATETIME NOT NULL, CHANGE etablissement_id etablissements_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D23B76CD FOREIGN KEY (etablissements_id) REFERENCES etablissements (id)');
        $this->addSql('CREATE INDEX IDX_42C84955D23B76CD ON reservation (etablissements_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D23B76CD');
        $this->addSql('DROP INDEX IDX_42C84955D23B76CD ON reservation');
        $this->addSql('ALTER TABLE reservation ADD heure_reservation DATETIME NOT NULL, CHANGE date_reservation date_reservation DATE NOT NULL, CHANGE etablissements_id etablissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissements (id)');
        $this->addSql('CREATE INDEX IDX_42C84955FF631228 ON reservation (etablissement_id)');
    }
}
