<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150414194738 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (
            id INT AUTO_INCREMENT NOT NULL,
            first_name VARCHAR(255) DEFAULT NULL,
            last_name VARCHAR(255) DEFAULT NULL,
            username VARCHAR(255) NOT NULL,
            username_canonical VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            email_canonical VARCHAR(255) NOT NULL,
            enabled TINYINT(1) NOT NULL,
            salt VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            last_login DATETIME DEFAULT NULL,
            locked TINYINT(1) NOT NULL,
            expired TINYINT(1) NOT NULL,
            expires_at DATETIME DEFAULT NULL,
            confirmation_token VARCHAR(255) DEFAULT NULL,
            password_requested_at DATETIME DEFAULT NULL,
            roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
            credentials_expired TINYINT(1) NOT NULL,
            credentials_expire_at DATETIME DEFAULT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical),
            UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
    }
}
