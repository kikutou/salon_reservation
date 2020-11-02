<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102013742 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
INSERT INTO `dtb_authority_role` (`id`, `authority_id`, `creator_id`, `deny_url`, `create_date`, `update_date`, `discriminator_type`) 
VALUES ('5', '2', '1', '/product', '2020-10-14 05:12:40', '2020-10-14 05:12:40', 'authorityrole');
INSERT INTO `dtb_authority_role` (`id`, `authority_id`, `creator_id`, `deny_url`, `create_date`, `update_date`, `discriminator_type`) 
VALUES ('6', '2', '1', '/order', '2020-10-14 05:12:40', '2020-10-14 05:12:40', 'authorityrole');
EOF
);

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
DELETE FROM `dtb_authority_role` WHERE id=5 or id=6;
EOF
	    );

    }
}
