<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215142039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_spot (user_id INT NOT NULL, spot_id INT NOT NULL, INDEX IDX_C3B336BAA76ED395 (user_id), INDEX IDX_C3B336BA2DF1D37C (spot_id), PRIMARY KEY(user_id, spot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_spot ADD CONSTRAINT FK_C3B336BAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_spot ADD CONSTRAINT FK_C3B336BA2DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_spot DROP FOREIGN KEY FK_C3B336BAA76ED395');
        $this->addSql('ALTER TABLE user_spot DROP FOREIGN KEY FK_C3B336BA2DF1D37C');
        $this->addSql('DROP TABLE user_spot');
    }
}
