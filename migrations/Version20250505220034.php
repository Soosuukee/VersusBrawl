<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250505220034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA7E48FD905 (game_id), INDEX IDX_3BAE0AA7B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event_team (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, event_id INT NOT NULL, is_validated TINYINT(1) NOT NULL, INDEX IDX_DB2BEAB4296CD8AE (team_id), INDEX IDX_DB2BEAB471F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, captain_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, players JSON NOT NULL, INDEX IDX_C4E0A61F3346729B (captain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_team ADD CONSTRAINT FK_DB2BEAB4296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_team ADD CONSTRAINT FK_DB2BEAB471F7E88B FOREIGN KEY (event_id) REFERENCES event (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3346729B FOREIGN KEY (captain_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7E48FD905
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7B03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_team DROP FOREIGN KEY FK_DB2BEAB4296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_team DROP FOREIGN KEY FK_DB2BEAB471F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F3346729B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_team
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE team
        SQL);
    }
}
