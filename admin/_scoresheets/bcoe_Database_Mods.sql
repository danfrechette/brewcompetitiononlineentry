DROP TABLE IF EXISTS `judging_packet_preferences`;
CREATE TABLE `judging_packet_preferences` (
  `id` int NOT NULL,
  `inc_flight_sheet` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `inc_specialty_sheet` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `inc_cover_sheet` enum('No','Standard','Themed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `inc_page_header` enum('No','As Text','As Image') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `inc_scoresheets` enum('No','Long Form','Short Form') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `inc_tracking_numbers` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `inc_cat_sponsors` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `inc_qrcodes` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `assigned_tracking_numbers` int NOT NULL DEFAULT '0' COMMENT 'Determins If Tracking Numbers Have Been Assigned',
  `json_packet_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `judging_packet_preferences`
  ADD PRIMARY KEY (`id`);
COMMIT;

ALTER TABLE `judging_packet_preferences`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

INSERT INTO `judging_packet_preferences` (`id`, `inc_flight_sheet`, `inc_specialty_sheet`, `inc_cover_sheet`, `inc_page_header`, `inc_scoresheets`, `inc_tracking_numbers`, `inc_cat_sponsors`, `inc_qrcodes`, `assigned_tracking_numbers`, `json_packet_images`) 
VALUES (NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', '0', NULL);






/* test queries */

SELECT SUBSTRING(COLUMN_TYPE,5)
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA='databasename' 
    AND TABLE_NAME='judging_packet_preferences'
    AND COLUMN_NAME='columnname'



    SHOW COLUMNS FROM `judging_packet_preferences` LIKE 'inc_flight_sheet';


