<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180212091923 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE teamleader_project (id INT AUTO_INCREMENT NOT NULL, project_nr INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE projects');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clients (id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, wid INT DEFAULT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (project_id INT NOT NULL, project_nr INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, contact_or_company VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, contact_or_company_id INT DEFAULT NULL, UNIQUE INDEX projects_projectId_uindex (project_id), PRIMARY KEY(project_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE teamleader_project');
    }
}
