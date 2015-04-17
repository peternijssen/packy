<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150414194741 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dependency (
                id INT AUTO_INCREMENT NOT NULL,
                project_id INT DEFAULT NULL,
                package_id INT DEFAULT NULL,
                raw_version LONGTEXT DEFAULT NULL,
                current_version LONGTEXT DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                INDEX IDX_2F585505166D1F9C (project_id),
                INDEX IDX_2F585505F44CABFF (package_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE package (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                manager VARCHAR(255) NOT NULL,
                latest_version LONGTEXT DEFAULT NULL,
                last_checked_at DATETIME DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL, PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('ALTER TABLE dependency ADD CONSTRAINT FK_2F585505166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE dependency ADD CONSTRAINT FK_2F585505F44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dependency DROP FOREIGN KEY FK_2F585505166D1F9C');
        $this->addSql('ALTER TABLE dependency DROP FOREIGN KEY FK_2F585505F44CABFF');
        $this->addSql('DROP TABLE dependency');
        $this->addSql('DROP TABLE package');
    }
}
