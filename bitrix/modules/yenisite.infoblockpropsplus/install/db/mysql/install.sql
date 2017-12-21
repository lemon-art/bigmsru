CREATE TABLE IF NOT EXISTS `yen_ipep_groups` (
	`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`NAME` varchar(200) NOT NULL,
	`MAIN_GROUP` varchar(200) NOT NULL,
	`IBLOCK_ID` int(10) unsigned NOT NULL,
	`SECTION_ID` int(10) unsigned NOT NULL DEFAULT '0',
	`SORT` int(10) unsigned NOT NULL,
	PRIMARY KEY (`ID`),
	UNIQUE KEY `uniq` (`NAME`,`IBLOCK_ID`) USING BTREE,
	KEY `iblock_id` (`IBLOCK_ID`)
);

CREATE TABLE IF NOT EXISTS `yen_ipep_props_to_groups` (
	`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`IBLOCK_ID` int(10) unsigned NOT NULL,
	`PROPERTY_ID` int(10) unsigned NOT NULL,
	`GROUP_ID` int(10) unsigned NOT NULL,
	PRIMARY KEY (`ID`),
	UNIQUE KEY `IPG` (`IBLOCK_ID`,`PROPERTY_ID`,`GROUP_ID`) USING BTREE,
	KEY `IBLOCK_ID` (`IBLOCK_ID`)
);