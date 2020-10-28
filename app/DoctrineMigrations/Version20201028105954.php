<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028105954 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
ADD COLUMN `hotpepper_store_id` INT UNSIGNED NULL AFTER `staff_number`;
ALTER TABLE `dtb_staff` 
ADD COLUMN `hotpepper_staff_id` INT UNSIGNED NULL AFTER `shop_id`;
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
DROP COLUMN `hotpepper_store_id`;
ALTER TABLE `dtb_staff` 
DROP COLUMN `hotpepper_staff_id`;
EOF
	    );

    }
}
