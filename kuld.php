<?php
// Beemeljük az adatbázis-kapcsolatot a másik fájlból
require "kapcsolat.php";
header("Content-Type: application/json; charset=utf-8");
// Kiolvassuk a névt a küldött adatokból (ha nincs, üres szöveg lesz)
$nev = trim($_POST["nev"] ?? "");
// Kiolvassuk az üzenet szövegét, a szóközöket levágjuk a széléről
$szoveg = trim($_POST["szoveg"] ?? "");
// Csak akkor mentünk, ha mindkettő ki van töltve
if ($nev != "" && $szoveg != "") {
    // Előkészítjük az SQL-t, a ? jelek helyére később kerülnek az adatok (így biztonságos)
    $parancs = $kapcsolat->prepare("INSERT INTO uzenetek (nev, szoveg) VALUES (?, ?)");
    // Megadjuk az értékeket: az "ss" azt jelenti, hogy két szöveg (string) jön
    $parancs->bind_param("ss", $nev, $szoveg);
    // Lefuttatjuk a mentést
    if (!$parancs->execute()) {
        http_response_code(500);
        echo json_encode(["hiba" => "Az üzenet mentése nem sikerült."]);
        exit;
    }
    echo json_encode([
        "id" => $kapcsolat->insert_id,
        "nev" => $nev,
        "szoveg" => $szoveg
    ], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(400);
    echo json_encode(["hiba" => "A név és az üzenet megadása kötelező."]);
}
