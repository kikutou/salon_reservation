<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116104000 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
ADD COLUMN `expire_date` date NULL AFTER `memo`;
EOF
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_shop` 
DROP COLUMN `expire_date`;
EOF
	    );

    }
}
