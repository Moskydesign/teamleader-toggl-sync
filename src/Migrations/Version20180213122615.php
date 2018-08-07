<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180213122615 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, project_nr INT NOT NULL, title VARCHAR(255) NOT NULL, contact_or_company VARCHAR(255) NOT NULL, contact_or_company_id INT NOT NULL, UNIQUE INDEX UNIQ_2FB3D0EEADF83C0A (project_nr), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE teamleader_project');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE teamleader_project (id INT AUTO_INCREMENT NOT NULL, project_nr INT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, contact_or_company VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, contact_or_company_id INT NOT NULL, project_id INT NOT NULL, UNIQUE INDEX UNIQ_3AC564712B36786B (title), UNIQUE INDEX UNIQ_3AC56471ADF83C0A (project_nr), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE project');
    }
}
