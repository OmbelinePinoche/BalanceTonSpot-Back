<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206103837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spot_sport (spot_id INT NOT NULL, sport_id INT NOT NULL, INDEX IDX_3EC471FA2DF1D37C (spot_id), INDEX IDX_3EC471FAAC78BCF8 (sport_id), PRIMARY KEY(spot_id, sport_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE spot_sport ADD CONSTRAINT FK_3EC471FA2DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spot_sport ADD CONSTRAINT FK_3EC471FAAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spot_sport DROP FOREIGN KEY FK_3EC471FA2DF1D37C');
        $this->addSql('ALTER TABLE spot_sport DROP FOREIGN KEY FK_3EC471FAAC78BCF8');
        $this->addSql('DROP TABLE spot_sport');
    }
}
