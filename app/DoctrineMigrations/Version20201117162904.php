<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117162904 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(<<<EOF
INSERT INTO `dtb_mail_template` (`id`, `name`, `file_name`, `mail_subject`, `create_date`, `update_date`, `discriminator_type`) VALUES (12, '有効期限切れ通知メール', 'Mail/expire_date_notification.twig', '有効期限切れのお知らせ', '2020-11-18 10:14:52', '2020-11-18 10:14:52', 'mailtemplate');
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<EOF
DELETE FROM `dtb_mail_template` WHERE `name`='有効期限切れ通知メール';
EOF
	    );

    }
}
