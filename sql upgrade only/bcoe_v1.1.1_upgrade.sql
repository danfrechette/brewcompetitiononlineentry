ALTER TABLE `brewing` CHANGE `id` `id` INT( 8 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `brewer` CHANGE `id` `id` INT( 8 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `styles` CHANGE `id` `id` INT( 8 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `preferences` CHANGE `id` `id` INT( 1 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `contest_info` ADD `contestWinnersComplete` TEXT NULL ;