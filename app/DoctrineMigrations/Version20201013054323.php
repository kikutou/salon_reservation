<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013054323 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
INSERT INTO `mtb_authority` (`id`, `name`, `sort_no`, `discriminator_type`) VALUES ('2', '加盟店', '2', 'authority');

EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
DELETE FROM `mtb_authority` WHERE id=2;

EOF
	    );

    }
}
