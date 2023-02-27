<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223104740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_sector_order_sign DROP FOREIGN KEY FK_D0ABBFF7481891DC');
        $this->addSql('ALTER TABLE material_sector_order_sign DROP FOREIGN KEY FK_D0ABBFF75AAD3E32');
        $this->addSql('ALTER TABLE material_sector_order_sign DROP FOREIGN KEY FK_D0ABBFF7F0A4F6B9');
        $this->addSql('DROP INDEX IDX_D0ABBFF7F0A4F6B9 ON material_sector_order_sign');
        $this->addSql('DROP INDEX IDX_D0ABBFF7481891DC ON material_sector_order_sign');
        $this->addSql('DROP INDEX IDX_D0ABBFF75AAD3E32 ON material_sector_order_sign');
        $this->addSql('ALTER TABLE material_sector_order_sign DROP item2_id, DROP item3_id, CHANGE item1_id sector_id INT NOT NULL');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF7DE95C867 FOREIGN KEY (sector_id) REFERENCES material_sector_sign_item (id)');
        $this->addSql('CREATE INDEX IDX_D0ABBFF7DE95C867 ON material_sector_order_sign (sector_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_sector_order_sign DROP FOREIGN KEY FK_D0ABBFF7DE95C867');
        $this->addSql('DROP INDEX IDX_D0ABBFF7DE95C867 ON material_sector_order_sign');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD item2_id INT DEFAULT NULL, ADD item3_id INT DEFAULT NULL, CHANGE sector_id item1_id INT NOT NULL');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF7481891DC FOREIGN KEY (item2_id) REFERENCES material_sector_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF75AAD3E32 FOREIGN KEY (item1_id) REFERENCES material_sector_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF7F0A4F6B9 FOREIGN KEY (item3_id) REFERENCES material_sector_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D0ABBFF7F0A4F6B9 ON material_sector_order_sign (item3_id)');
        $this->addSql('CREATE INDEX IDX_D0ABBFF7481891DC ON material_sector_order_sign (item2_id)');
        $this->addSql('CREATE INDEX IDX_D0ABBFF75AAD3E32 ON material_sector_order_sign (item1_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
