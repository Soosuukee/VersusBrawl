<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515145003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE game_match (id INT AUTO_INCREMENT NOT NULL, phase_id INT NOT NULL, start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', end_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_finished TINYINT(1) NOT NULL, round_label VARCHAR(255) NOT NULL, lobbycode VARCHAR(20) DEFAULT NULL, INDEX IDX_4868BC8A99091188 (phase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE match_participant (id INT AUTO_INCREMENT NOT NULL, game_match_id INT NOT NULL, team_id INT DEFAULT NULL, player_id INT DEFAULT NULL, score INT DEFAULT NULL, placement INT NOT NULL, is_winner TINYINT(1) DEFAULT NULL, INDEX IDX_E5061A3981FA53F0 (game_match_id), INDEX IDX_E5061A39296CD8AE (team_id), INDEX IDX_E5061A3999E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE phase (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', end_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_finished TINYINT(1) NOT NULL, round_labeling_mode VARCHAR(255) NOT NULL, INDEX IDX_B1BDD6CB71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE phase_team (phase_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_34671B3199091188 (phase_id), INDEX IDX_34671B31296CD8AE (team_id), PRIMARY KEY(phase_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game_match ADD CONSTRAINT FK_4868BC8A99091188 FOREIGN KEY (phase_id) REFERENCES phase (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant ADD CONSTRAINT FK_E5061A3981FA53F0 FOREIGN KEY (game_match_id) REFERENCES game_match (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant ADD CONSTRAINT FK_E5061A39296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant ADD CONSTRAINT FK_E5061A3999E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase_team ADD CONSTRAINT FK_34671B3199091188 FOREIGN KEY (phase_id) REFERENCES phase (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase_team ADD CONSTRAINT FK_34671B31296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE game_match DROP FOREIGN KEY FK_4868BC8A99091188
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant DROP FOREIGN KEY FK_E5061A3981FA53F0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant DROP FOREIGN KEY FK_E5061A39296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant DROP FOREIGN KEY FK_E5061A3999E6F5DF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase DROP FOREIGN KEY FK_B1BDD6CB71F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase_team DROP FOREIGN KEY FK_34671B3199091188
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase_team DROP FOREIGN KEY FK_34671B31296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game_match
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE match_participant
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE phase
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE phase_team
        SQL);
    }
}
