<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518232406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE scoring_rule (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, type VARCHAR(20) NOT NULL, position INT NOT NULL, points INT NOT NULL, INDEX IDX_C38D49FC71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoring_rule ADD CONSTRAINT FK_C38D49FC71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD scoring_mode VARCHAR(50) NOT NULL, DROP is_ranked_by_points
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE scoring_rule DROP FOREIGN KEY FK_C38D49FC71F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scoring_rule
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD is_ranked_by_points TINYINT(1) NOT NULL, DROP scoring_mode
        SQL);
    }
}
