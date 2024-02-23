<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222124746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE rating rating NUMERIC(2, 1) DEFAULT NULL');
        $this->addSql('ALTER TABLE comment RENAME INDEX fk_comment_user TO IDX_9474526CA76ED395');
        $this->addSql('ALTER TABLE spot CHANGE rating rating NUMERIC(2, 1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE rating rating NUMERIC(2, 1) NOT NULL');
        $this->addSql('ALTER TABLE comment RENAME INDEX idx_9474526ca76ed395 TO fk_comment_user');
        $this->addSql('ALTER TABLE spot CHANGE rating rating NUMERIC(2, 1) NOT NULL');
    }
}
