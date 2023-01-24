<?php

function &db_connect()
{
  require_once 'DB.php';
  PEAR::setErrorHandling(PEAR_ERROR_DIE);

  // RREINHARDT: 2016-08-19 
  // MIGRATION TO AWS RDS INSTANCE

  //$db_host = 'localhost';
  //$db_user = 'ppvuser';
  //$db_pass = 'sanuBadr232wRaKafeCh';
  //$db_name = 'PlayFullScreen';

  $db_host = 'vidizu-mysql-east-1.chwzkboodw6d.us-east-1.rds.amazonaws.com';
  $db_user = 'wp';
  $db_pass = 'SNKs4XLS';
  $db_name = 'vidizu';

  //$dsn = "mysql://$db_user:$db_pass@unix+$db_host/$db_name";

  $dsn = "mysql://$db_user:$db_pass@$db_host/$db_name";

  $db = DB::connect($dsn);
  if (PEAR::isError($db)) {
    error_log('Could not connect to DB');
    return NULL;
  }
  $db->setFetchMode(DB_FETCHMODE_OBJECT);
  $db->query("SET NAMES utf8");
  return $db;
}
