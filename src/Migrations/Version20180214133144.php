<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180214133144 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE time_entry (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, entry_id INT NOT NULL, uid INT NOT NULL, description VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, duration INT NOT NULL, tags LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', exported TINYINT(1) NOT NULL, INDEX IDX_6E537C0C166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE time_entry ADD CONSTRAINT FK_6E537C0C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE time_entry');
    }
}
