<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201018230346 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
INSERT INTO `dtb_mail_template` (`id`, `name`, `file_name`, `mail_subject`, `create_date`, `update_date`, `discriminator_type`) VALUES (9, '掲載店登録受付メール', 'Mail/shop_entry_confirm.twig', '掲載店登録受付のご確認', '2020-10-19 10:14:52', '2020-10-19 10:14:52', 'mailtemplate');
INSERT INTO `dtb_mail_template` (`id`, `name`, `file_name`, `mail_subject`, `create_date`, `update_date`, `discriminator_type`) VALUES (10, '掲載店登録完了メール', 'Mail/shop_entry_complete.twig', '掲載店登録が完了しました。', '2020-10-19 10:14:52', '2020-10-19 10:14:52', 'mailtemplate');
INSERT INTO `dtb_mail_template` (`id`, `name`, `file_name`, `mail_subject`, `create_date`, `update_date`, `discriminator_type`) VALUES (11, '掲載店承認メール', 'Mail/shop_entry_confirm_to_admin.twig', '掲載店登録申請がありました。', '2020-10-19 10:14:52', '2020-10-19 10:14:52', 'mailtemplate');
EOF
	    );

    }

    public function down(Schema $schema) : void
    {
	    $this->addSql(<<<EOF
DELETE FROM `dtb_mail_template` WHERE `name`='掲載店登録受付メール';
DELETE FROM `dtb_mail_template` WHERE `name`='掲載店登録完了メール';
DELETE FROM `dtb_mail_template` WHERE `name`='掲載店承認メール';
EOF
	    );

    }
}
