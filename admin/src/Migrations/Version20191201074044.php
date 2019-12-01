<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191201074044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, city_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, about LONGTEXT DEFAULT NULL, phone VARCHAR(50) NOT NULL, sex SMALLINT DEFAULT NULL, birthday DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8B308530A76ED395 (user_id), INDEX IDX_8B3085308BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_users (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, social_id VARCHAR(50) NOT NULL, provider VARCHAR(20) NOT NULL, social_name VARCHAR(50) NOT NULL, social_image VARCHAR(255) NOT NULL, social_token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5E13117BFFEB5B27 (social_id), INDEX IDX_5E13117BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, token LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D95DB16B98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B308530A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B3085308BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE social_users ADD CONSTRAINT FK_5E13117BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16B98260155 FOREIGN KEY (region_id) REFERENCES regions (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B308530A76ED395');
        $this->addSql('ALTER TABLE social_users DROP FOREIGN KEY FK_5E13117BA76ED395');
        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B3085308BAC62AF');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16B98260155');
        $this->addSql('DROP TABLE profiles');
        $this->addSql('DROP TABLE social_users');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE regions');
    }
}
