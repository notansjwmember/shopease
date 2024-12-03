<?php
$db_uri = 'postgresql://postgres.suqveoqemcidqyshjxdz:Titemo.123!@aws-0-us-east-1.pooler.supabase.com:6543/postgres';

$url = parse_url($db_uri);

$host = $url['host'];
$port = $url['port'];
$dbname = ltrim($url['path'], '/');
$user = $url['user'];
$password = $url['pass'];

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected to the database.";
} catch (PDOException $e) {
  echo "Connecion failed: " . $e->getMessage();
}
