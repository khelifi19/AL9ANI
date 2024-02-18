<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217232639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Check if the primary key index exists
        $indexes = $schema->getTable('reclamation')->getIndexes();
        $primaryKeyExists = isset($indexes['PRIMARY']);

        // If the primary key index exists, drop it
        if ($primaryKeyExists) {
            $this->addSql('ALTER TABLE reclamation DROP PRIMARY KEY');
        }

        // Add the new columns
        $this->addSql('ALTER TABLE reclamation ADD nom_reclamation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD prenom_reclamation VARCHAR(255) NOT NULL');

        // If the primary key index did not exist, add it now
        if (!$primaryKeyExists) {
            $this->addSql('ALTER TABLE reclamation ADD PRIMARY KEY (id)');
        }

        // Add the new primary key constraint
        $this->addSql('ALTER TABLE reclamation ADD id_reclamation INT AUTO_INCREMENT PRIMARY KEY');
    }

    public function down(Schema $schema): void
    {
        // Drop the new columns
        $this->addSql('ALTER TABLE reclamation DROP COLUMN nom_reclamation');
        $this->addSql('ALTER TABLE reclamation DROP COLUMN prenom_reclamation');

        // Drop the new primary key constraint
        $this->addSql('ALTER TABLE reclamation DROP PRIMARY KEY');

        // Add the old primary key constraint back
        $this->addSql('ALTER TABLE reclamation ADD PRIMARY KEY (id)');
    }
}
