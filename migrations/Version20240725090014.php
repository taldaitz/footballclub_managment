<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725090014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, team_in_id INT NOT NULL, team_out_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_232B318CD7FF3773 (team_in_id), INDEX IDX_232B318C72141FA3 (team_out_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD7FF3773 FOREIGN KEY (team_in_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C72141FA3 FOREIGN KEY (team_out_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD7FF3773');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C72141FA3');
        $this->addSql('DROP TABLE game');
    }
}
