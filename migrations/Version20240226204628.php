<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226204628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement MODIFY id_event INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON evenement');
        $this->addSql('ALTER TABLE evenement CHANGE id_event id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX IDX_CE70D424D52B4B97 ON pass');
        $this->addSql('ALTER TABLE pass ADD evenement_id INT NOT NULL, DROP id_event');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D424FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_CE70D424FD02F13 ON pass (evenement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON evenement');
        $this->addSql('ALTER TABLE evenement CHANGE id id_event INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD PRIMARY KEY (id_event)');
        $this->addSql('ALTER TABLE pass DROP FOREIGN KEY FK_CE70D424FD02F13');
        $this->addSql('DROP INDEX IDX_CE70D424FD02F13 ON pass');
        $this->addSql('ALTER TABLE pass ADD id_event INT DEFAULT NULL, DROP evenement_id');
        $this->addSql('CREATE INDEX IDX_CE70D424D52B4B97 ON pass (id_event)');
    }
}
