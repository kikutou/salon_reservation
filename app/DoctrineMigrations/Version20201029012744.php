<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029012744 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_order` 
ADD COLUMN `shop_id` INT NOT NULL;
EOF
	    );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
