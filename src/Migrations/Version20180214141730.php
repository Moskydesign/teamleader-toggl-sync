<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180214141730 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE time_entry DROP FOREIGN KEY FK_6E537C0C166D1F9C');
        $this->addSql('DROP INDEX IDX_6E537C0C166D1F9C ON time_entry');
        $this->addSql('ALTER TABLE time_entry CHANGE project_id milestone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE time_entry ADD CONSTRAINT FK_6E537C0C4B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
        $this->addSql('CREATE INDEX IDX_6E537C0C4B3E2EDA ON time_entry (milestone_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE time_entry DROP FOREIGN KEY FK_6E537C0C4B3E2EDA');
        $this->addSql('DROP INDEX IDX_6E537C0C4B3E2EDA ON time_entry');
        $this->addSql('ALTER TABLE time_entry CHANGE milestone_id project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE time_entry ADD CONSTRAINT FK_6E537C0C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_6E537C0C166D1F9C ON time_entry (project_id)');
    }
}
