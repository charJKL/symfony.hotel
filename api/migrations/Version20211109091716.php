<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211109091716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, status INT UNSIGNED NOT NULL, check_in_at DATETIME NOT NULL, check_out_at DATETIME NOT NULL, book_at DATETIME NOT NULL, contact VARCHAR(255) NOT NULL, rooms_amount INT UNSIGNED NOT NULL, people_amount INT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accommodation ADD reservation_id INT DEFAULT NULL, DROP book_at, DROP rooms_amount, DROP people_amount');
        $this->addSql('ALTER TABLE accommodation ADD CONSTRAINT FK_2D385412B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_2D385412B83297E7 ON accommodation (reservation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation DROP FOREIGN KEY FK_2D385412B83297E7');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP INDEX IDX_2D385412B83297E7 ON accommodation');
        $this->addSql('ALTER TABLE accommodation ADD book_at DATETIME DEFAULT NULL, ADD rooms_amount INT UNSIGNED NOT NULL, ADD people_amount INT UNSIGNED NOT NULL, DROP reservation_id');
    }
}
