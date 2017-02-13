<?php
// Kết nối với CSDL
$connect = @mysql_pconnect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die ('Can not connect to database');
$db = @mysql_select_db(DB_NAME,$connect) or die ('Can not select database');

//Yêu cầu lưu trữ UTF8 (Tiếng Việt)
mysql_query('SET NAMES UTF8', $connect);
?>