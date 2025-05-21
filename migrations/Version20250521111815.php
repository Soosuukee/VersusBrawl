<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521111815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD category VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant DROP FOREIGN KEY FK_2CF02B9ABCD3C787
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2CF02B9ABCD3C787 ON matchgame_participant
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant CHANGE matchgame_id match_game_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant ADD CONSTRAINT FK_2CF02B9A9329866A FOREIGN KEY (match_game_id) REFERENCES matchgame (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2CF02B9A9329866A ON matchgame_participant (match_game_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant DROP FOREIGN KEY FK_2CF02B9A9329866A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2CF02B9A9329866A ON matchgame_participant
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant CHANGE match_game_id matchgame_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame_participant ADD CONSTRAINT FK_2CF02B9ABCD3C787 FOREIGN KEY (matchgame_id) REFERENCES matchgame (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2CF02B9ABCD3C787 ON matchgame_participant (matchgame_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP category
        SQL);
    }
}
