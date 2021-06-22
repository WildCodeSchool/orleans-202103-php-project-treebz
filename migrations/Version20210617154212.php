<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617154212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command_theme (command_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_4DDB23B33E1689A (command_id), INDEX IDX_4DDB23B59027487 (theme_id), PRIMARY KEY(command_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command_theme ADD CONSTRAINT FK_4DDB23B33E1689A FOREIGN KEY (command_id) REFERENCES command (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE command_theme ADD CONSTRAINT FK_4DDB23B59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE command_theme');
    }
}
