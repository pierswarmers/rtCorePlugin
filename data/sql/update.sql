-- TABLE UPDATES

-- Version 0.0.1 - June 25 2010

ALTER TABLE `rt_site` ADD COLUMN `reference_key` VARCHAR(255);
ALTER TABLE `rt_site` DROP COLUMN `template_dir`;
ALTER TABLE `rt_site` DROP COLUMN `is_primary`;