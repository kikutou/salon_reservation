<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201019064556 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
CHANGE COLUMN `creadit_cards_info` `credit_cards_info` TEXT NULL DEFAULT NULL ;
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
CHANGE COLUMN `credit_cards_info` `creadit_cards_info` TEXT NULL DEFAULT NULL ;
EOF
	    );
    }
}
