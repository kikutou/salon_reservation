<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104071704 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_menu` 
CHANGE COLUMN `shop_id` `shop_id` INT UNSIGNED NOT NULL ;
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_menu` 
CHANGE COLUMN `shop_id` `shop_id` INT NOT NULL ;
EOF
	    );

    }
}
