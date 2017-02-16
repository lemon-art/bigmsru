<?php
/* Ansible managed: /etc/ansible/roles/web/templates/after_connect_d7.php.j2 modified on 2015-06-15 05:31:17 by root on s0565780c.fastvps-server.com */
$connection = \Bitrix\Main\Application::getConnection();

$connection->queryExecute("SET NAMES 'utf8'");
$connection->queryExecute("SET collation_connection = 'utf8_unicode_ci'");
$connection->queryExecute('SET LOCAL time_zone="'.date('P').'"');
