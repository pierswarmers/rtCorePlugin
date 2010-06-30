-- TABLE UPDATES

-- Version 0.0.1 - June 25 2010

ALTER TABLE `rt_site` ADD COLUMN `reference_key` VARCHAR(255);
ALTER TABLE `rt_site` DROP COLUMN `template_dir`;
ALTER TABLE `rt_site` DROP COLUMN `is_primary`;

-- Version 0.0.2 - June 29 2010

ALTER TABLE `rt_address` ADD COLUMN `instructions` TEXT;
ALTER TABLE `rt_address` ADD COLUMN `first_name` VARCHAR(100);
ALTER TABLE `rt_address` ADD COLUMN `last_name` VARCHAR(100);

ALTER TABLE `rt_shop_order` ADD COLUMN `voucher_code` VARCHAR(100);

