<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523145530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE event_user (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_92589AE271F7E88B (event_id), INDEX IDX_92589AE2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_user ADD CONSTRAINT FK_92589AE271F7E88B FOREIGN KEY (event_id) REFERENCES event (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_user ADD CONSTRAINT FK_92589AE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD is_solo TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame CHANGE start_date start_date DATETIME NOT NULL, CHANGE end_date end_date DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase CHANGE start_date start_date DATETIME NOT NULL, CHANGE end_date end_date DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team_member CHANGE joined_at joined_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL, CHANGE available_at available_at DATETIME NOT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE271F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE2A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP is_solo, CHANGE created_at created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE phase CHANGE start_date start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE end_date end_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE available_at available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team_member CHANGE joined_at joined_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchgame CHANGE start_date start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE end_date end_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }
}
