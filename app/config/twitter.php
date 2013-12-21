<?php
/**
 * twconnect library configuration
 */

$active_group = "default";
$active_record = TRUE;
$CI =& get_instance();

$db['default']['hostname'] = $CI->config->item('hostname');
$host = $db['default']['hostname'];
$db['default']['username'] = $CI->config->item('db_username');
$user = $db['default']['username'];
$db['default']['password'] = $CI->config->item('db_password');
$pass = $db['default']['password'];
$db['default']['database'] = $CI->config->item('db');
$dbb = $db['default']['database'];

$con = mysql_connect("$host","$user","$pass");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("$dbb", $con);
/* Access tokens */

$query = mysql_query("SELECT code,string_value FROM settings WHERE code ='SITE_TWITTER_API_ID'");

while($row = mysql_fetch_array($query))
{
   $consumer_key = $row['string_value'];

}

$query1 = mysql_query("SELECT code,string_value FROM settings WHERE code ='SITE_TWITTER_API_SECRET'");

while($row1 = mysql_fetch_array($query1))
{
   $consumer_secret = $row1['string_value'];

}
 $config = array(
  'consumer_key'    => $consumer_key,
  'consumer_secret' => $consumer_secret,
   'oauth_callback'      => 'oob' // Default callback application path
);

/*
$config = array(
  'consumer_key'    => 'PRz0JGyNebFttDnhWeg',
  'consumer_secret' => 's8E2tAEkHDmBHTRtOgQdcNVpMBHg8fpk434CrukLeQ',
   'oauth_callback'      => 'oob' // Default callback application path
);
*/
?>