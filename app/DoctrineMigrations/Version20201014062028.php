<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014062028 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_shop`
CHANGE COLUMN `persion_in_charge` `person_in_charge` TEXT NULL DEFAULT NULL COMMENT '担当者名' ;

EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_shop`
CHANGE COLUMN `person_in_charge` `persion_in_charge` TEXT NULL DEFAULT NULL COMMENT '担当者名' ;
EOF
	    );

    }
}
