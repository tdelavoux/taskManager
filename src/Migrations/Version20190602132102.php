<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190602132102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, fk_sprint_id INT NOT NULL, fk_person_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, deadline DATE DEFAULT NULL, commentaire VARCHAR(500) DEFAULT NULL, INDEX IDX_93872075ED7DD0EB (fk_sprint_id), INDEX IDX_9387207540226CD7 (fk_person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075ED7DD0EB FOREIGN KEY (fk_sprint_id) REFERENCES sprint (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207540226CD7 FOREIGN KEY (fk_person_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tache');
    }
}
