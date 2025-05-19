<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519092940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE team_member (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, team_id INT NOT NULL, is_captain TINYINT(1) NOT NULL, joined_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_6FFBDA199E6F5DF (player_id), INDEX IDX_6FFBDA1296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team_member ADD CONSTRAINT FK_6FFBDA199E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team_member ADD CONSTRAINT FK_6FFBDA1296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game ADD type VARCHAR(50) NOT NULL, ADD banner VARCHAR(255) NOT NULL, ADD heroes VARCHAR(255) NOT NULL, CHANGE image icon VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame RENAME INDEX idx_424480fe99091188 TO IDX_6A0E89A899091188
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F3346729B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C4E0A61F3346729B ON team
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP captain_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE team_member DROP FOREIGN KEY FK_6FFBDA199E6F5DF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team_member DROP FOREIGN KEY FK_6FFBDA1296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE team_member
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame RENAME INDEX idx_6a0e89a899091188 TO IDX_424480FE99091188
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game ADD image VARCHAR(255) NOT NULL, DROP type, DROP icon, DROP banner, DROP heroes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team ADD captain_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3346729B FOREIGN KEY (captain_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C4E0A61F3346729B ON team (captain_id)
        SQL);
    }
}
