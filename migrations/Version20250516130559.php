<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516130559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE matchgame (id INT AUTO_INCREMENT NOT NULL, phase_id INT NOT NULL, start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', end_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_finished TINYINT(1) NOT NULL, round_label VARCHAR(255) NOT NULL, lobbycode VARCHAR(20) DEFAULT NULL, INDEX IDX_424480FE99091188 (phase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE matchgame_participant (id INT AUTO_INCREMENT NOT NULL, matchgame_id INT NOT NULL, team_id INT DEFAULT NULL, player_id INT DEFAULT NULL, score INT DEFAULT NULL, placement INT NOT NULL, is_winner TINYINT(1) DEFAULT NULL, INDEX IDX_2CF02B9ABCD3C787 (matchgame_id), INDEX IDX_2CF02B9A296CD8AE (team_id), INDEX IDX_2CF02B9A99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame ADD CONSTRAINT FK_424480FE99091188 FOREIGN KEY (phase_id) REFERENCES phase (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant ADD CONSTRAINT FK_2CF02B9ABCD3C787 FOREIGN KEY (matchgame_id) REFERENCES matchgame (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant ADD CONSTRAINT FK_2CF02B9A296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant ADD CONSTRAINT FK_2CF02B9A99E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant DROP FOREIGN KEY FK_E5061A39296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant DROP FOREIGN KEY FK_E5061A3981FA53F0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant DROP FOREIGN KEY FK_E5061A3999E6F5DF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game_match DROP FOREIGN KEY FK_4868BC8A99091188
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE match_participant
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game_match
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE match_participant (id INT AUTO_INCREMENT NOT NULL, game_match_id INT NOT NULL, team_id INT DEFAULT NULL, player_id INT DEFAULT NULL, score INT DEFAULT NULL, placement INT NOT NULL, is_winner TINYINT(1) DEFAULT NULL, INDEX IDX_E5061A3999E6F5DF (player_id), INDEX IDX_E5061A3981FA53F0 (game_match_id), INDEX IDX_E5061A39296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE game_match (id INT AUTO_INCREMENT NOT NULL, phase_id INT NOT NULL, start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', end_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_finished TINYINT(1) NOT NULL, round_label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lobbycode VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_4868BC8A99091188 (phase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant ADD CONSTRAINT FK_E5061A39296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant ADD CONSTRAINT FK_E5061A3981FA53F0 FOREIGN KEY (game_match_id) REFERENCES game_match (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_participant ADD CONSTRAINT FK_E5061A3999E6F5DF FOREIGN KEY (player_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game_match ADD CONSTRAINT FK_4868BC8A99091188 FOREIGN KEY (phase_id) REFERENCES phase (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame DROP FOREIGN KEY FK_424480FE99091188
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant DROP FOREIGN KEY FK_2CF02B9ABCD3C787
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant DROP FOREIGN KEY FK_2CF02B9A296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant DROP FOREIGN KEY FK_2CF02B9A99E6F5DF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE matchgame
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE matchgame_participant
        SQL);
    }
}
