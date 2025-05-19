<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519010912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE player_stats (id INT AUTO_INCREMENT NOT NULL, match_participant_id INT NOT NULL, player_id INT NOT NULL, eliminations INT NOT NULL, deaths INT DEFAULT NULL, assists INT DEFAULT NULL, damage INT DEFAULT NULL, headshots INT DEFAULT NULL, external_id VARCHAR(100) DEFAULT NULL, source VARCHAR(50) DEFAULT NULL, player_score DOUBLE PRECISION DEFAULT NULL, INDEX IDX_E8351CEC14B54424 (match_participant_id), INDEX IDX_E8351CEC99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE player_stats ADD CONSTRAINT FK_E8351CEC14B54424 FOREIGN KEY (match_participant_id) REFERENCES matchgame_participant (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE player_stats ADD CONSTRAINT FK_E8351CEC99E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_team ADD points_total INT DEFAULT NULL, ADD ranking INT DEFAULT NULL, ADD note LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant ADD status VARCHAR(50) DEFAULT NULL, ADD is_disqualified TINYINT(1) DEFAULT 0 NOT NULL, ADD eliminations_total INT DEFAULT NULL, ADD note VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase ADD phase_order INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoring_rule ADD phase_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoring_rule ADD CONSTRAINT FK_C38D49FC99091188 FOREIGN KEY (phase_id) REFERENCES phase (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C38D49FC99091188 ON scoring_rule (phase_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team CHANGE players players JSON DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE player_stats DROP FOREIGN KEY FK_E8351CEC14B54424
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE player_stats DROP FOREIGN KEY FK_E8351CEC99E6F5DF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE player_stats
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase DROP phase_order
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant DROP status, DROP is_disqualified, DROP eliminations_total, DROP note
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team CHANGE players players JSON NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoring_rule DROP FOREIGN KEY FK_C38D49FC99091188
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C38D49FC99091188 ON scoring_rule
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoring_rule DROP phase_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_team DROP points_total, DROP ranking, DROP note
        SQL);
    }
}
