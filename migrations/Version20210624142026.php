<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624142026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_detail (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, address VARCHAR(500) NOT NULL, postal_code VARCHAR(5) NOT NULL, town VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(35) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD user_detail_id INT DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D8308E5F FOREIGN KEY (user_detail_id) REFERENCES user_detail (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D8308E5F ON user (user_detail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D8308E5F');
        $this->addSql('DROP TABLE user_detail');
        $this->addSql('DROP INDEX UNIQ_8D93D649D8308E5F ON user');
        $this->addSql('ALTER TABLE user DROP user_detail_id, DROP is_verified');
    }
}
