<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013013504 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    if($schema->hasTable("dtb_staff")){
		    return;
	    }
	    $this->addSql(<<<EOF
CREATE TABLE `dtb_staff` (
  `id` INT UNSIGNED NOT NULL,
  `shop_id` INT NOT NULL,
  `name` TEXT NULL,
  `image` TEXT NULL,
  `title` TEXT NULL,
  `introduction` TEXT NULL,
  `experience` TEXT NULL,
  `style` TEXT NULL,
  `skills` TEXT NULL,
  `hobbies` TEXT NULL,
  `image_1` TEXT NULL,
  `comment_1` TEXT NULL,
  `images_2` TEXT NULL,
  `comment_2` TEXT NULL,
  `images_3` TEXT NULL,
  `comment_3` TEXT NULL,
  `image_4` TEXT NULL,
  `comment_4` TEXT NULL,
  `business_hours` TEXT NULL,
  `memo` TEXT NULL,
  `create_date` DATETIME NULL,
  `update_date` DATETIME NULL,
  PRIMARY KEY (`id`));
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    if(!$schema->hasTable("dtb_staff")){
		    return;
	    }
	    $this->addSql(<<<EOF
DROP TABLE `dtb_staff`;
EOF
	    );
    }
}
