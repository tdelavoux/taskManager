<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190601163135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sprint DROP FOREIGN KEY FK_EF8055B748F25C6B');
        $this->addSql('DROP INDEX UNIQ_EF8055B748F25C6B ON sprint');
        $this->addSql('ALTER TABLE sprint DROP fk_color_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sprint ADD fk_color_id INT NOT NULL');
        $this->addSql('ALTER TABLE sprint ADD CONSTRAINT FK_EF8055B748F25C6B FOREIGN KEY (fk_color_id) REFERENCES color (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EF8055B748F25C6B ON sprint (fk_color_id)');
    }
}
