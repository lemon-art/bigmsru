<?
$updater->CopyFiles("install/components", "components");
$updater->CopyFiles("install/css", "css");
$updater->CopyFiles("install/gadgets", "gadgets");
$updater->CopyFiles("install/js", "js");

if ($updater->CanUpdateDatabase())
{
	if(!$DB->Query("select LANGUAGE_ID from b_event_message WHERE 1=0", true))
	{
		$updater->Query(array(
			"MySQL"  => "alter table b_event_message add column LANGUAGE_ID char(2) NULL",
			"Oracle" => "alter table b_event_message add LANGUAGE_ID char(2 char) NULL",
			"MSSQL"  => "alter table b_event_message add LANGUAGE_ID char(2) NULL",
		));
	}

	if(!$DB->Query("select LANGUAGE_ID from b_event WHERE 1=0", true))
	{
		$updater->Query(array(
			"MySQL"  => "alter table b_event add column LANGUAGE_ID char(2) NULL",
			"Oracle" => "alter table b_event add LANGUAGE_ID char(2 char) NULL",
			"MSSQL"  => "alter table b_event add LANGUAGE_ID char(2) NULL",
		));
	}
}

