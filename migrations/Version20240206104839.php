<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206104839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spot DROP FOREIGN KEY FK_B9327A73918DB72');
        $this->addSql('DROP INDEX IDX_B9327A73918DB72 ON spot');
        $this->addSql('ALTER TABLE spot CHANGE location_id_id location_id INT NOT NULL');
        $this->addSql('ALTER TABLE spot ADD CONSTRAINT FK_B9327A7364D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_B9327A7364D218E ON spot (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spot DROP FOREIGN KEY FK_B9327A7364D218E');
        $this->addSql('DROP INDEX IDX_B9327A7364D218E ON spot');
        $this->addSql('ALTER TABLE spot CHANGE location_id location_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE spot ADD CONSTRAINT FK_B9327A73918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_B9327A73918DB72 ON spot (location_id_id)');
    }
}
