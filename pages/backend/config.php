<?php
$regDB = '(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.15.5)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = UBUREG))
)';

$regUser = "ubudev";
$regPasswd = "esubu";

$ubureg = oci_connect($regUser, $regPasswd, $regDB, 'AL32UTF8');

if (!$ubureg) {
    $e = oci_error();
    die("Connection failed: " . htmlentities($e['message'], ENT_QUOTES));
}
?>