<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210713072302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shipping_address (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, address LONGTEXT NOT NULL, postal_code VARCHAR(25) NOT NULL, town VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, INDEX IDX_EB066945A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shipping_address ADD CONSTRAINT FK_EB066945A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE command ADD shipping_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD44D4CFF2B FOREIGN KEY (shipping_address_id) REFERENCES shipping_address (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD44D4CFF2B ON command (shipping_address_id)');
        $this->addSql('ALTER TABLE status ADD color VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD44D4CFF2B');
        $this->addSql('DROP TABLE shipping_address');
        $this->addSql('DROP INDEX IDX_8ECAEAD44D4CFF2B ON command');
        $this->addSql('ALTER TABLE command DROP shipping_address_id');
        $this->addSql('ALTER TABLE status DROP color');
    }
}
