<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029111014 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_staff_menu`
CHANGE COLUMN `product_id` `menu_id` INT NULL;
ALTER TABLE `dtb_staff_menu`
CHANGE COLUMN `staff_id` `staff_id` INT NULL;
EOF
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_staff_menu`
CHANGE COLUMN `menu_id` `product_id` INT NOT NULL;
ALTER TABLE `dtb_staff_menu`
CHANGE COLUMN `staff_id` `staff_id` INT NOT NULL;
EOF
	    );

    }
}
