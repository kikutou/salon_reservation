<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013011636 extends AbstractMigration
{

    public function up(Schema $schema) : void
    {
	    if($schema->hasTable("dtb_shop")){
		    return;
	    }
	    $this->addSql(<<<EOF
CREATE TABLE `dtb_shop` (
  `id` INT UNSIGNED NOT NULL COMMENT 'ID',
  `member_id` INT NOT NULL COMMENT 'メンバーID',
  `open_status` INT NULL DEFAULT 1 COMMENT '開業状況\n1: 開業済み 2: 開業予定\n',
  `name` TEXT NULL COMMENT '店舗名',
  `persion_in_charge` TEXT NULL COMMENT '担当者名',
  `industry_type` INT NULL COMMENT '業種\n1:ヘアサロン 2:ネイル・まつげサロン 3:リラクサロン 4.エステサロン 5. その他',
  `post_code` VARCHAR(7) NULL,
  `mtb_pref_id` INT NULL,
  `address` TEXT NULL,
  `telephone` TEXT NULL,
  `email` TEXT NULL,
  `url` TEXT NULL,
  `question` TEXT NULL,
  `authenticated_by_admin` INT NULL COMMENT '1: 審査中 2:審査済み 3：却下　※却下は直接削除になるため、該当ステータスは基本的に使わない。',
  `public_status` INT NULL COMMENT '1: 非公開 2:公開',
  `logo` TEXT NULL,
  `top_images` TEXT NULL,
  `tags` TEXT NULL,
  `sub_name` TEXT NULL,
  `access` TEXT NULL,
  `business_hours` TEXT NULL,
  `creadit_cards_info` TEXT NULL,
  `price` TEXT NULL,
  `seats` TEXT NULL,
  `staff_number` TEXT NULL,
  `parking_area` TEXT NULL,
  `conditions` TEXT NULL,
  `introduction_title` TEXT NULL,
  `introduction` TEXT NULL,
  `introduction_images` TEXT NULL,
  `commitment_title_1` TEXT NULL,
  `commitment_image_1` TEXT NULL,
  `commitment_introduction_1` TEXT NULL,
  `commitment_title_2` TEXT NULL,
  `commitment_image_2` TEXT NULL,
  `commitment_introduction_2` TEXT NULL,
  `environment_title_1` TEXT NULL,
  `environment_image_1` TEXT NULL,
  `environment_introduction_1` TEXT NULL,
  `environment_title_2` TEXT NULL,
  `environment_image_2` TEXT NULL,
  `environment_introduction_2` TEXT NULL,
  `environment_title_3` TEXT NULL,
  `environment_image_3` TEXT NULL,
  `environment_introduction_3` TEXT NULL,
  `message` TEXT NULL,
  `message_staff_position` TEXT NULL,
  `message_staff` TEXT NULL,
  `message_image` TEXT NULL,
  `memo` TEXT NULL,
  `create_date` DATETIME NULL,
  `update_date` DATETIME NULL,
  PRIMARY KEY (`id`));

EOF
);

    }

    public function down(Schema $schema) : void
    {

	    if(!$schema->hasTable("dtb_shop")){
		    return;
	    }
	    $this->addSql(<<<EOF
DROP TABLE `dtb_shop`;
EOF
	    );

    }
}
