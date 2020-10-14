<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014051412 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
INSERT INTO `dtb_authority_role` (`id`, `authority_id`, `creator_id`, `deny_url`, `create_date`, `update_date`, `discriminator_type`) 
VALUES ('1', '2', '1', '/setting', '2020-10-14 05:12:40', '2020-10-14 05:12:40', 'authorityrole');
INSERT INTO `dtb_authority_role` (`id`, `authority_id`, `creator_id`, `deny_url`, `create_date`, `update_date`, `discriminator_type`) 
VALUES ('2', '2', '1', '/content', '2020-10-14 05:12:40', '2020-10-14 05:12:40', 'authorityrole');
INSERT INTO `dtb_authority_role` (`id`, `authority_id`, `creator_id`, `deny_url`, `create_date`, `update_date`, `discriminator_type`) 
VALUES ('3', '2', '1', '/store', '2020-10-14 05:12:40', '2020-10-14 05:12:40', 'authorityrole');
INSERT INTO `dtb_authority_role` (`id`, `authority_id`, `creator_id`, `deny_url`, `create_date`, `update_date`, `discriminator_type`) 
VALUES ('4', '2', '1', '/customer', '2020-10-14 05:12:40', '2020-10-14 05:12:40', 'authorityrole');

EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
DELETE FROM `dtb_authority_role` WHERE 1=1;
EOF
		);

    }
}
