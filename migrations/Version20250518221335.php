<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518221335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE matchgame (id INT AUTO_INCREMENT NOT NULL, phase_id INT NOT NULL, start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', end_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_finished TINYINT(1) NOT NULL, round_label VARCHAR(255) NOT NULL, lobbycode VARCHAR(20) DEFAULT NULL, INDEX IDX_6A0E89A899091188 (phase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame ADD CONSTRAINT FK_6A0E89A899091188 FOREIGN KEY (phase_id) REFERENCES phase (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game ADD heroes VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant ADD CONSTRAINT FK_2CF02B9ABCD3C787 FOREIGN KEY (matchgame_id) REFERENCES matchgame (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant DROP FOREIGN KEY FK_2CF02B9ABCD3C787
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame DROP FOREIGN KEY FK_6A0E89A899091188
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE matchgame
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game DROP heroes
        SQL);
    }
}
