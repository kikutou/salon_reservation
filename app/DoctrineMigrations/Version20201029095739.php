<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029095739 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_reservation` 
ADD COLUMN `memo` TEXT NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `canceled_at` DATETIME NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `note` TEXT NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `memo_admin` TEXT NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `message_to_shop` TEXT NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `message_sended_status` INT NULL COMMENT '1:未通知 2:通知済み 3:通知失敗';
ALTER TABLE `dtb_reservation` 
ADD COLUMN `message_sended_at` DATETIME NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `customer_id` INT NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `point` INT NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `point_sum_before_reservation` INT NULL;
ALTER TABLE `dtb_reservation` 
ADD COLUMN `created_at` DATETIME NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `starttime` `starttime` INT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `shop_id` `shop_id` INT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `menu_id` `menu_id` INT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `staff_id` `staff_id` INT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `status` `status` INT NULL COMMENT '1:予約可 2:予約ずみ 3:キャンセル';
EOF
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_reservation` 
DROP COLUMN `memo`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `canceled_at`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `note`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `memo_admin`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `message_to_shop`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `message_sended_status`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `message_sended_at`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `customer_id`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `point`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `point_sum_before_reservation`;
ALTER TABLE `dtb_reservation` 
DROP COLUMN `created_at`;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `starttime` `starttime` INT NOT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `shop_id` `shop_id` INT NOT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `menu_id` `menu_id` INT NOT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `staff_id` `staff_id` INT NOT NULL;
ALTER TABLE `dtb_reservation`
CHANGE COLUMN `status` `status` INT NOT NULL COMMENT '1:予約可 2:予約ずみ 3:キャンセル';
EOF
	    );

    }
}
