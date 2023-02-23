<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223145508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_sector_sign_item DROP FOREIGN KEY FK_51F7FAB412469DE2');
        $this->addSql('DROP TABLE material_sector_sign_item_category');
        $this->addSql('DROP INDEX IDX_51F7FAB412469DE2 ON material_sector_sign_item');
        $this->addSql('ALTER TABLE material_sector_sign_item DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_sector_sign_item_category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE material_sector_sign_item ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE material_sector_sign_item ADD CONSTRAINT FK_51F7FAB412469DE2 FOREIGN KEY (category_id) REFERENCES material_sector_sign_item_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_51F7FAB412469DE2 ON material_sector_sign_item (category_id)');
    }
}
