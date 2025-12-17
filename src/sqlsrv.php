<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$serverName = "AMECTESTDB\AMECTSINST"; 
$connectionInfo = [
    "Database" => "mkt",
    "UID"      => "mktsys",
    "PWD"      => "P@ssmkt*1",
    "LoginTimeout" => 5,
    "CharacterSet" => "UTF-8",
];

$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    echo "<pre>";
    print_r(sqlsrv_errors());
    echo "</pre>";
    exit;
}

echo "✅ Connected OK";