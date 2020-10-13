<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013013849 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    if($schema->hasTable("dtb_staff_menu")){
		    return;
	    }
	    $this->addSql(<<<EOF
CREATE TABLE `dtb_staff_menu` (
  `id` INT UNSIGNED NOT NULL,
  `shop_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`id`));
EOF
	    );


    }

    public function down(Schema $schema) : void
    {
	    if(!$schema->hasTable("dtb_staff_menu")){
		    return;
	    }
	    $this->addSql(<<<EOF
DROP TABLE `dtb_staff_menu`;
EOF
	    );

    }
}
