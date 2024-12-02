<?php
$host = 'aws-0-eu-central-1.pooler.supabase.com';
$db = 'postgres';
$user = 'postgres.ragepwbaervictvcfkuj';
$password = 'Taima2004@';
$port = '6543';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connection successful!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>