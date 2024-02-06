<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206110018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5B05007F');
        $this->addSql('DROP INDEX IDX_9474526C5B05007F ON comment');
        $this->addSql('ALTER TABLE comment CHANGE spot_id_id spot_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C2DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id)');
        $this->addSql('CREATE INDEX IDX_9474526C2DF1D37C ON comment (spot_id)');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F895B05007F');
        $this->addSql('DROP INDEX IDX_16DB4F895B05007F ON picture');
        $this->addSql('ALTER TABLE picture CHANGE spot_id_id spot_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F892DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F892DF1D37C ON picture (spot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C2DF1D37C');
        $this->addSql('DROP INDEX IDX_9474526C2DF1D37C ON comment');
        $this->addSql('ALTER TABLE comment CHANGE spot_id spot_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5B05007F FOREIGN KEY (spot_id_id) REFERENCES spot (id)');
        $this->addSql('CREATE INDEX IDX_9474526C5B05007F ON comment (spot_id_id)');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F892DF1D37C');
        $this->addSql('DROP INDEX IDX_16DB4F892DF1D37C ON picture');
        $this->addSql('ALTER TABLE picture CHANGE spot_id spot_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F895B05007F FOREIGN KEY (spot_id_id) REFERENCES spot (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F895B05007F ON picture (spot_id_id)');
    }
}
