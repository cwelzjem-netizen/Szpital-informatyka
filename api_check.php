<?php
// api_check.php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

// Odbierz dane JSON z Reacta
$input = json_decode(file_get_contents('php://input'), true);

$pacjentId = $input['pacjent_id'];
$oddzialId = $input['oddzial_id'];
$lekarzId = $input['lekarz_id'];
$badaniaIds = $input['badania_ids'] ?? [];
$lekiIds = $input['leki_ids'] ?? [];
$diagnozaTekst = $input['diagnoza_tekst'];

$punkty = 0;
$wiadomosci = [];

try {
    // 1. Pobierz poprawne rozwiązanie dla pacjenta
    $stmt = $pdo->prepare("SELECT * FROM poprawne_diagnozy WHERE pacjent_id = ?");
    $stmt->execute([$pacjentId]);
    $klucz = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$klucz) {
        echo json_encode(['sukces' => false, 'punkty' => 0, 'wiadomosci' => ['Brak danych dla tego pacjenta']]);
        exit;
    }

    // 2. Sprawdź Oddział (20 pkt)
    if ($oddzialId == $klucz['oddzial_id']) {
        $punkty += 20;
    } else {
        $wiadomosci[] = "Wybrano niewłaściwy oddział.";
    }

    // 3. Sprawdź Lekarza (20 pkt)
    if ($lekarzId == $klucz['lekarz_id']) {
        $punkty += 20;
    } else {
        $wiadomosci[] = "Wybrano niewłaściwego lekarza.";
    }

    // 4. Sprawdź Tekst Diagnozy (20 pkt) - proste dopasowanie (case insensitive)
    if (strpos(mb_strtolower($diagnozaTekst), mb_strtolower($klucz['diagnoza'])) !== false) {
        $punkty += 20;
    } else {
        $wiadomosci[] = "Nietrafiona nazwa diagnozy. Sugerowana: " . $klucz['diagnoza'];
    }

    // 5. Sprawdź Badania (20 pkt)
    $stmt = $pdo->prepare("SELECT badanie_id FROM poprawne_badania WHERE diagnoza_id = ?");
    $stmt->execute([$klucz['id']]);
    $wymaganeBadania = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Logika: muszą być wybrane wszystkie wymagane
    $badaniaOk = !array_diff($wymaganeBadania, $badaniaIds); 
    if ($badaniaOk && count($badaniaIds) >= count($wymaganeBadania)) {
        $punkty += 20;
    } else {
        $wiadomosci[] = "Zlecono nieprawidłowe lub niepełne badania.";
    }

    // 6. Sprawdź Leki (20 pkt)
    $stmt = $pdo->prepare("SELECT lek_id FROM poprawne_leki WHERE diagnoza_id = ?");
    $stmt->execute([$klucz['id']]);
    $wymaganeLeki = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $lekiOk = !array_diff($wymaganeLeki, $lekiIds);
    if ($lekiOk && count($lekiIds) >= count($wymaganeLeki)) {
        $punkty += 20;
    } else {
        $wiadomosci[] = "Przepisano nieprawidłowe leki.";
    }

    $sukces = $punkty >= 60;

    echo json_encode([
        'sukces' => $sukces,
        'punkty' => $punkty,
        'wiadomosci' => $wiadomosci
    ]);

} catch (PDOException $e) {
    echo json_encode(['sukces' => false, 'wiadomosci' => ['Błąd SQL: ' . $e->getMessage()]]);
}
?>