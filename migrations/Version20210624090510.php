<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624090510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `member` DROP FOREIGN KEY FK_70E4FA7833E1689A');
        $this->addSql('DROP INDEX IDX_70E4FA7833E1689A ON `member`');
        $this->addSql('ALTER TABLE `member` ADD number INT NOT NULL, DROP command_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `member` ADD command_id INT DEFAULT NULL, DROP number');
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT FK_70E4FA7833E1689A FOREIGN KEY (command_id) REFERENCES command (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_70E4FA7833E1689A ON `member` (command_id)');
    }
}
