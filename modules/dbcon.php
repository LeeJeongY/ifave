<?
$SERVER		= "localhost";
$DATABASE	= "sports365";
$DBUSER		= "sports365";
$DBPASSWD	= "8338#2201kg";

$dbconn = @mysql_connect("$SERVER","$DBUSER","$DBPASSWD");
@mysql_query("set names utf8");

$db_status = @mysql_select_db("$DATABASE");
if (!$db_status) {
   echo "DB가 다운 되었거나 DB에 연결 할 수 없습니다.";
   exit;
}
?>