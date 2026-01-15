<?php
// db.php
$host = 'localhost';
$db   = 'szpital'; // Nazwa twojej bazy danych
$user = 'postgres'; // Twój użytkownik postgres
$pass = 'Cosinus'; // WPISZ TU SWOJE HASŁO DO BAZY
$port = "5432";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die(json_encode(["error" => "Błąd połączenia z bazą: " . $e->getMessage()]));
}
?>