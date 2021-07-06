<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701143820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD status_id INT DEFAULT NULL, ADD contact_information_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD quantity INT NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD46BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD45D0DBFC1 FOREIGN KEY (contact_information_id) REFERENCES user_detail (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD46BF700BD ON command (status_id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD45D0DBFC1 ON command (contact_information_id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD4A76ED395 ON command (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD46BF700BD');
        $this->addSql('DROP TABLE status');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD45D0DBFC1');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4A76ED395');
        $this->addSql('DROP INDEX IDX_8ECAEAD46BF700BD ON command');
        $this->addSql('DROP INDEX IDX_8ECAEAD45D0DBFC1 ON command');
        $this->addSql('DROP INDEX IDX_8ECAEAD4A76ED395 ON command');
        $this->addSql('ALTER TABLE command DROP status_id, DROP contact_information_id, DROP user_id, DROP quantity, DROP created_at');
    }
}
