<?php
// api_init.php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

try {
    // Pobierz oddziały
    $stmt = $pdo->query("SELECT * FROM oddzialy");
    $oddzialy = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pobierz lekarzy
    $stmt = $pdo->query("SELECT * FROM lekarze");
    $lekarze = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pobierz pacjentów
    $stmt = $pdo->query("SELECT * FROM pacjenci");
    $pacjenci = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pobierz badania
    $stmt = $pdo->query("SELECT * FROM badania");
    $badania = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pobierz leki
    $stmt = $pdo->query("SELECT * FROM leki");
    $leki = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Zwróć wszystko jako jeden obiekt JSON
    echo json_encode([
        'oddzialy' => $oddzialy,
        'lekarze' => $lekarze,
        'pacjenci' => $pacjenci,
        'badania' => $badania,
        'leki' => $leki
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>