<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220012159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pass ADD id_event INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D424D52B4B97 FOREIGN KEY (id_event) REFERENCES evenement (idEvent)');
        $this->addSql('CREATE INDEX IDX_CE70D424D52B4B97 ON pass (id_event)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pass DROP FOREIGN KEY FK_CE70D424D52B4B97');
        $this->addSql('DROP INDEX IDX_CE70D424D52B4B97 ON pass');
        $this->addSql('ALTER TABLE pass DROP id_event');
    }
}
