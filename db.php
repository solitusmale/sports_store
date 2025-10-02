<?php
$host = 'localhost';
$db   = 'sports_store';
$user = 'root';
$pass = ''; // podesi ako tvoja baza ima lozinku
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Konekcija sa bazom nije uspela: " . $e->getMessage());
}
?>
