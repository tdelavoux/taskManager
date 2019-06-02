<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190602173502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, fk_sprint_id INT NOT NULL, fk_user_id INT DEFAULT NULL, fk_statut_id INT NOT NULL, fk_priorite_id INT NOT NULL, libelle VARCHAR(200) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, deadline DATE DEFAULT NULL, INDEX IDX_93872075ED7DD0EB (fk_sprint_id), INDEX IDX_938720755741EEB9 (fk_user_id), INDEX IDX_938720759779EF94 (fk_statut_id), INDEX IDX_938720753A425DEA (fk_priorite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075ED7DD0EB FOREIGN KEY (fk_sprint_id) REFERENCES sprint (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720755741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720759779EF94 FOREIGN KEY (fk_statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720753A425DEA FOREIGN KEY (fk_priorite_id) REFERENCES priorite (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tache');
    }
}
