<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211007161828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facilities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms_facilities (rooms_id INT NOT NULL, facilities_id INT NOT NULL, INDEX IDX_C7AD4DEB8E2368AB (rooms_id), INDEX IDX_C7AD4DEB5263402 (facilities_id), PRIMARY KEY(rooms_id, facilities_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rooms_facilities ADD CONSTRAINT FK_C7AD4DEB8E2368AB FOREIGN KEY (rooms_id) REFERENCES rooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rooms_facilities ADD CONSTRAINT FK_C7AD4DEB5263402 FOREIGN KEY (facilities_id) REFERENCES facilities (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rooms_facilities DROP FOREIGN KEY FK_C7AD4DEB5263402');
        $this->addSql('ALTER TABLE rooms_facilities DROP FOREIGN KEY FK_C7AD4DEB8E2368AB');
        $this->addSql('DROP TABLE facilities');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE rooms_facilities');
    }
}
