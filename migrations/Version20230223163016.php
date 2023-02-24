<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223163016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_algeco_order_sign DROP FOREIGN KEY FK_B7715503481891DC');
        $this->addSql('ALTER TABLE material_algeco_order_sign DROP FOREIGN KEY FK_B77155035AAD3E32');
        $this->addSql('ALTER TABLE material_algeco_order_sign DROP FOREIGN KEY FK_B77155036D73CE00');
        $this->addSql('ALTER TABLE material_algeco_order_sign DROP FOREIGN KEY FK_B7715503F0A4F6B9');
        $this->addSql('DROP TABLE material_algeco_sign_item');
        $this->addSql('DROP INDEX IDX_B77155036D73CE00 ON material_algeco_order_sign');
        $this->addSql('DROP INDEX IDX_B7715503F0A4F6B9 ON material_algeco_order_sign');
        $this->addSql('DROP INDEX IDX_B7715503481891DC ON material_algeco_order_sign');
        $this->addSql('DROP INDEX IDX_B77155035AAD3E32 ON material_algeco_order_sign');
        $this->addSql('ALTER TABLE material_algeco_order_sign DROP item1_id, DROP item2_id, DROP item3_id, DROP item4_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_algeco_sign_item (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE material_algeco_order_sign ADD item1_id INT NOT NULL, ADD item2_id INT DEFAULT NULL, ADD item3_id INT DEFAULT NULL, ADD item4_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE material_algeco_order_sign ADD CONSTRAINT FK_B7715503481891DC FOREIGN KEY (item2_id) REFERENCES material_algeco_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_algeco_order_sign ADD CONSTRAINT FK_B77155035AAD3E32 FOREIGN KEY (item1_id) REFERENCES material_algeco_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_algeco_order_sign ADD CONSTRAINT FK_B77155036D73CE00 FOREIGN KEY (item4_id) REFERENCES material_algeco_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_algeco_order_sign ADD CONSTRAINT FK_B7715503F0A4F6B9 FOREIGN KEY (item3_id) REFERENCES material_algeco_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B77155036D73CE00 ON material_algeco_order_sign (item4_id)');
        $this->addSql('CREATE INDEX IDX_B7715503F0A4F6B9 ON material_algeco_order_sign (item3_id)');
        $this->addSql('CREATE INDEX IDX_B7715503481891DC ON material_algeco_order_sign (item2_id)');
        $this->addSql('CREATE INDEX IDX_B77155035AAD3E32 ON material_algeco_order_sign (item1_id)');
    }
}
