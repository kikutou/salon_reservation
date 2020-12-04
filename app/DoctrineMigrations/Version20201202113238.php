<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202113238 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
ADD COLUMN `remark` text NULL AFTER `memo`;
ALTER TABLE `dtb_shop` 
ADD COLUMN `regular_holiday` text NULL AFTER `business_hours`;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `check_status` INT NOT NULL DEFAULT 1 COMMENT '1:未読 2:確認済' AFTER `status`;
ALTER TABLE `dtb_menu` 
CHANGE COLUMN `price` `price` INT NULL;
EOF
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
DROP COLUMN `remark`;
ALTER TABLE `dtb_shop` 
DROP COLUMN `regular_holiday`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `check_status`;
ALTER TABLE `dtb_menu` 
CHANGE COLUMN `price` `price` TEXT NULL;
EOF
	    );

    }
}
