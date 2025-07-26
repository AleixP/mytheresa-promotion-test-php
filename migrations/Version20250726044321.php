<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250726044321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prices (id INT AUTO_INCREMENT NOT NULL, sku VARCHAR(255) NOT NULL, price INT UNSIGNED NOT NULL, currency VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX idx_sku_currency (sku, currency), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL COMMENT \'(DC2Type:sku)\', category ENUM(\'boots\' , \'sandals\' , \'shoes\' , \'sneakers\' ) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX uniq_product_sku (sku), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotions (id INT AUTO_INCREMENT NOT NULL, applicable_to VARCHAR(255) NOT NULL, percentage INT NOT NULL, promotion_type ENUM(\'sku\' , \'category\' ) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idx_applicable_to (applicable_to), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prices');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE promotions');
    }
}
