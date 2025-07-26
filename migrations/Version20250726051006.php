<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250726051006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA1B30343A24DFB6AA7F3FCC ON promotions (promotion_type, applicable_to)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_EA1B30343A24DFB6AA7F3FCC ON promotions');
        $this->addSql('ALTER TABLE promotions CHANGE promotion_type promotion_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE products CHANGE category category VARCHAR(255) NOT NULL');
    }
}
