<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206103403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, spot_id_id INT NOT NULL, INDEX IDX_9474526C5B05007F (spot_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, spot_id_id INT NOT NULL, INDEX IDX_16DB4F895B05007F (spot_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE spot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, rating NUMERIC(2, 1) DEFAULT NULL, location_id_id INT NOT NULL, INDEX IDX_B9327A73918DB72 (location_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE spot_sport (spot_id INT NOT NULL, sport_id INT NOT NULL, INDEX IDX_3EC471FA2DF1D37C (spot_id), INDEX IDX_3EC471FAAC78BCF8 (sport_id), PRIMARY KEY(spot_id, sport_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5B05007F FOREIGN KEY (spot_id_id) REFERENCES spot (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F895B05007F FOREIGN KEY (spot_id_id) REFERENCES spot (id)');
        $this->addSql('ALTER TABLE spot ADD CONSTRAINT FK_B9327A73918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE spot_sport ADD CONSTRAINT FK_3EC471FA2DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spot_sport ADD CONSTRAINT FK_3EC471FAAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5B05007F');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F895B05007F');
        $this->addSql('ALTER TABLE spot DROP FOREIGN KEY FK_B9327A73918DB72');
        $this->addSql('ALTER TABLE spot_sport DROP FOREIGN KEY FK_3EC471FA2DF1D37C');
        $this->addSql('ALTER TABLE spot_sport DROP FOREIGN KEY FK_3EC471FAAC78BCF8');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE spot');
        $this->addSql('DROP TABLE spot_sport');
        $this->addSql('DROP TABLE user');
    }
}
