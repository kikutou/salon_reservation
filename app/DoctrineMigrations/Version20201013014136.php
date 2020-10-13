<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013014136 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    if($schema->hasTable("dtb_reservation")){
		    return;
	    }
	    $this->addSql(<<<EOF
CREATE TABLE `dtb_reservation` (
  `id` INT UNSIGNED NOT NULL,
  `order_id` INT NOT NULL,
  `starttime` INT NOT NULL,
  `shop_id` INT NOT NULL,
  `menu_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `status` INT NOT NULL COMMENT '1:予約可 2:予約ずみ 3:キャンセル',
  PRIMARY KEY (`id`));
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    if(!$schema->hasTable("dtb_reservation")){
		    return;
	    }
	    $this->addSql(<<<EOF
DROP TABLE `dtb_reservation`;
EOF
	    );

    }
}
