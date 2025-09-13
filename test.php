<?php
$servername = "sql12.freesqldatabase.com";  // Database Host
$username   = "sql12798325";                // Database Username
$password   = "2nKjASgD3l";                  // Database Password
$database   = "sql12798325";                // Database Name
$port       = 3306;                         // Default MySQL port

$conn = mysqli_connect($servername, $username, $password, $database, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
echo "✅ Connected successfully to FreeSQLDatabase!";
?>
