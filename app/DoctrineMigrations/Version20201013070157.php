<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013070157 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID' ;
ALTER TABLE `dtb_staff` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID' ;
ALTER TABLE `dtb_staff_menu` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID' ;
ALTER TABLE `dtb_reservation` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID' ;
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL COMMENT 'ID' ;
ALTER TABLE `dtb_staff` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL COMMENT 'ID' ;
ALTER TABLE `dtb_staff_menu` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL COMMENT 'ID' ;
ALTER TABLE `dtb_reservation` 
CHANGE COLUMN `id` `id` INT UNSIGNED NOT NULL COMMENT 'ID' ;
EOF
	    );

    }
}
