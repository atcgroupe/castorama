<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224105528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_service_order_sign DROP FOREIGN KEY FK_C44DB6F48D9F6D38');
        $this->addSql('ALTER TABLE material_service_order_sign DROP FOREIGN KEY FK_C44DB6F4481891DC');
        $this->addSql('ALTER TABLE material_service_order_sign DROP FOREIGN KEY FK_C44DB6F45AAD3E32');
        $this->addSql('ALTER TABLE material_service_order_sign DROP FOREIGN KEY FK_C44DB6F46FC7C15');
        $this->addSql('DROP TABLE material_service_order_sign');
        $this->addSql('DROP TABLE material_service_sign_item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_service_order_sign (id INT AUTO_INCREMENT NOT NULL, item1_id INT NOT NULL, item2_id INT NOT NULL, sign_id INT NOT NULL, order_id INT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_C44DB6F48D9F6D38 (order_id), INDEX IDX_C44DB6F46FC7C15 (sign_id), INDEX IDX_C44DB6F45AAD3E32 (item1_id), INDEX IDX_C44DB6F4481891DC (item2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE material_service_sign_item (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_active TINYINT(1) NOT NULL, color VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE material_service_order_sign ADD CONSTRAINT FK_C44DB6F48D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_service_order_sign ADD CONSTRAINT FK_C44DB6F4481891DC FOREIGN KEY (item2_id) REFERENCES material_service_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_service_order_sign ADD CONSTRAINT FK_C44DB6F45AAD3E32 FOREIGN KEY (item1_id) REFERENCES material_service_sign_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material_service_order_sign ADD CONSTRAINT FK_C44DB6F46FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
