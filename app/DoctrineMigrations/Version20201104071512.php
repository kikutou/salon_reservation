<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104071512 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_reservation` 
CHANGE COLUMN `shop_id` `shop_id` INT UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `menu_id` `menu_id` INT UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `staff_id` `staff_id` INT UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `customer_id` `customer_id` INT UNSIGNED NULL DEFAULT NULL ;
EOF
	    );
    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_reservation` 
CHANGE COLUMN `shop_id` `shop_id` INT NULL DEFAULT NULL ,
CHANGE COLUMN `menu_id` `menu_id` INT NULL DEFAULT NULL ,
CHANGE COLUMN `staff_id` `staff_id` INT NULL DEFAULT NULL ,
CHANGE COLUMN `customer_id` `customer_id` INT NULL DEFAULT NULL ;
EOF
	    );

    }
}
