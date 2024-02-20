<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220004939 extends AbstractMigration
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
        $this->addSql('ALTER TABLE pass MODIFY id_pass INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON pass');
        $this->addSql('ALTER TABLE pass ADD idevent_id INT NOT NULL, CHANGE id_pass id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D424DB22A086 FOREIGN KEY (idevent_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_CE70D424DB22A086 ON pass (idevent_id)');
        $this->addSql('ALTER TABLE pass ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON evenement');
        $this->addSql('ALTER TABLE evenement CHANGE id id_event INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD PRIMARY KEY (id_event)');
        $this->addSql('ALTER TABLE pass MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE pass DROP FOREIGN KEY FK_CE70D424DB22A086');
        $this->addSql('DROP INDEX IDX_CE70D424DB22A086 ON pass');
        $this->addSql('DROP INDEX `PRIMARY` ON pass');
        $this->addSql('ALTER TABLE pass DROP idevent_id, CHANGE id id_pass INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE pass ADD PRIMARY KEY (id_pass)');
    }
}
