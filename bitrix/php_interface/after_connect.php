<?php
/* Ansible managed: /etc/ansible/roles/web/templates/after_connect.php.j2 modified on 2015-06-15 05:31:17 by root on s0565780c.fastvps-server.com */
$DB->Query("SET NAMES 'utf8'");
$DB->Query('SET collation_connection = "utf8_unicode_ci"');
$DB->Query("SET LOCAL time_zone='".date('P')."'");