<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029095742 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        if($schema->hasTable("dtb_menu")){
		    return;
	    }
	    $this->addSql(<<<EOF
CREATE TABLE `dtb_menu` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `shop_id` INT NOT NULL,
    `title` TEXT NULL,
    `introduction` TEXT NULL,
    `price` TEXT NULL,
    `category_id` INT NULL,
    `hotpepper_menu_id` TEXT NULL,
    `memo` TEXT NULL,
    `create_date` DATETIME NULL,
    `update_date` DATETIME NULL,
    PRIMARY KEY (`id`));
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
        if(!$schema->hasTable("dtb_menu")){
		    return;
	    }
	    $this->addSql(<<<EOF
DROP TABLE `dtb_menu`;
EOF
	    );

    }
}
