<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106171302 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_reservation` 
ADD COLUMN `canceled_at_by_user` DATETIME NULL AFTER `canceled_at`;
EOF
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<EOF
ALTER TABLE `dtb_reservation` 
DROP COLUMN `canceled_at_by_user`;
EOF
	    );

    }
}
