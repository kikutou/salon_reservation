<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201019095256 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_staff` 
CHANGE COLUMN `images_2` `image_2` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `images_3` `image_3` TEXT NULL DEFAULT NULL ;
EOF
	    );
    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_staff` 
CHANGE COLUMN `image_2` `images_2` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `image_3` `images_3` TEXT NULL DEFAULT NULL ;
EOF
	    );

    }
}
