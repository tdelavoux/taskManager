<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190512144426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, passwd VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE access_team');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE compo_team');
        $this->addSql('DROP TABLE criticite');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE histo_projet');
        $this->addSql('DROP TABLE histo_sprint');
        $this->addSql('DROP TABLE histo_tableau');
        $this->addSql('DROP TABLE histo_tache');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE sprint');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE tableau');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE users');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE access_team (fkTeam INT NOT NULL, fkTableau INT NOT NULL, INDEX fk_at_tableau (fkTableau), PRIMARY KEY(fkTeam, fkTableau)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, codeHexa VARCHAR(7) DEFAULT NULL COLLATE latin1_swedish_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE compo_team (fkUser INT NOT NULL, fkTeam INT NOT NULL, fkStatus INT DEFAULT NULL, INDEX fk_ct_team (fkTeam), INDEX fk_ct_status (fkStatus), PRIMARY KEY(fkUser, fkTeam)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE criticite (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkColor INT DEFAULT NULL, INDEX fk_criticite_color (fkColor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkColor INT DEFAULT NULL, INDEX fk_etat_color (fkColor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE histo_projet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE histo_sprint (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkTableau INT DEFAULT NULL, fkColor INT DEFAULT NULL, INDEX fk_sprint_color (fkColor), INDEX fk_sprint_tableau (fkTableau), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE histo_tableau (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkProjet INT DEFAULT NULL, INDEX fk_tableau_projet (fkProjet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE histo_tache (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkSprint INT DEFAULT NULL, fkUser INT DEFAULT NULL, fkEtat INT DEFAULT NULL, fkCriticite INT DEFAULT NULL, dateDebut DATE DEFAULT NULL, dateFin DATE DEFAULT NULL, commentaire VARCHAR(500) DEFAULT NULL COLLATE latin1_swedish_ci, INDEX fk_ht_user (fkUser), INDEX fk_ht_criticite (fkCriticite), INDEX fk_ht_hs (fkSprint), INDEX fk_ht_etat (fkEtat), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sprint (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkTableau INT DEFAULT NULL, fkColor INT DEFAULT NULL, INDEX fk_sprint_color (fkColor), INDEX fk_sprint_table (fkTableau), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, inactif TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tableau (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkProjet INT DEFAULT NULL, INDEX fk_tableau_projet (fkProjet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, fkSprint INT DEFAULT NULL, fkUser INT DEFAULT NULL, fkEtat INT DEFAULT NULL, fkCriticite INT DEFAULT NULL, dateDebut DATE DEFAULT NULL, dateFin DATE DEFAULT NULL, commentaire VARCHAR(500) DEFAULT NULL COLLATE latin1_swedish_ci, INDEX fk_tache_user (fkUser), INDEX fk_tache_criticite (fkCriticite), INDEX fk_tache_sprint (fkSprint), INDEX fk_tache_etat (fkEtat), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL COLLATE latin1_swedish_ci, inactif TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(20) NOT NULL COLLATE latin1_swedish_ci, prenom VARCHAR(60) DEFAULT NULL COLLATE latin1_swedish_ci, nom VARCHAR(60) DEFAULT NULL COLLATE latin1_swedish_ci, mdp VARCHAR(200) DEFAULT NULL COLLATE latin1_swedish_ci, inactif TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE user');
    }
}
