<?php

$host = "db";
$dbname = getenv("MYSQL_DATABASE") ?: "sl33z";
$username = getenv("MYSQL_USER") ?: "u6607532";
$password = getenv("MYSQL_PASSWORD");

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database Connection Failed");
}
