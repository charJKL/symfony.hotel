<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211016093645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accommodation (id INT UNSIGNED AUTO_INCREMENT NOT NULL, status INT UNSIGNED NOT NULL, check_in_at DATETIME NOT NULL, check_out_at DATETIME NOT NULL, book_at DATETIME DEFAULT NULL, rooms_amount INT UNSIGNED NOT NULL, people_amount INT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accommodation_room (accommodation_id INT UNSIGNED NOT NULL, room_id INT NOT NULL, INDEX IDX_7BA793508F3692CD (accommodation_id), INDEX IDX_7BA7935054177093 (room_id), PRIMARY KEY(accommodation_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accommodation_guest (accommodation_id INT UNSIGNED NOT NULL, guest_id INT NOT NULL, INDEX IDX_A008B9CF8F3692CD (accommodation_id), INDEX IDX_A008B9CF9A4AA658 (guest_id), PRIMARY KEY(accommodation_id, guest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guest (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, document_id VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accommodation_room ADD CONSTRAINT FK_7BA793508F3692CD FOREIGN KEY (accommodation_id) REFERENCES accommodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accommodation_room ADD CONSTRAINT FK_7BA7935054177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accommodation_guest ADD CONSTRAINT FK_A008B9CF8F3692CD FOREIGN KEY (accommodation_id) REFERENCES accommodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accommodation_guest ADD CONSTRAINT FK_A008B9CF9A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) ON DELETE CASCADE');
			$this->addSql('ALTER TABLE accommodation ADD CONSTRAINT accommodation_chk_1 CHECK (check_in_at < check_out_at)');
		  $this->addSql('ALTER TABLE guest ADD CONSTRAINT guest_chk_1 CHECK ((name IS NOT NULL AND surname IS NOT NULL AND document_id IS NOT NULL) OR (email IS NOT NULL OR phone IS NOT NULL))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation_room DROP FOREIGN KEY FK_7BA793508F3692CD');
        $this->addSql('ALTER TABLE accommodation_guest DROP FOREIGN KEY FK_A008B9CF8F3692CD');
        $this->addSql('ALTER TABLE accommodation_guest DROP FOREIGN KEY FK_A008B9CF9A4AA658');
        $this->addSql('DROP TABLE accommodation');
        $this->addSql('DROP TABLE accommodation_room');
        $this->addSql('DROP TABLE accommodation_guest');
        $this->addSql('DROP TABLE guest');
    }
}
