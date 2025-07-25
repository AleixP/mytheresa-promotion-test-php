<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725102731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promotions (id INT AUTO_INCREMENT NOT NULL, applicable_to VARCHAR(255) NOT NULL, percentage INT NOT NULL, promotion_type ENUM(\'sku\' , \'category\' ) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idx_applicable_to (applicable_to), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products CHANGE category category ENUM(\'boots\' , \'sandals\' , \'shoes\' , \'sneakers\' ) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promotions');
        $this->addSql('ALTER TABLE products CHANGE category category VARCHAR(255) NOT NULL');
    }
}
