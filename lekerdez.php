<?php
// Beemeljük az adatbázis-kapcsolatot
require "kapcsolat.php";
// Megmondjuk a böngészőnek, hogy ne tárolja el a választ (különben nem látná az új üzeneteket)
header("Cache-Control: no-store");
// Jelezzük, hogy JSON jön
header("Content-Type: application/json; charset=utf-8");
// Kiolvassuk az utolsó ismert üzenet azonosítóját (számmá alakítjuk, alapérték 0)
$utolso = (int)($_GET["utolso"] ?? 0);
// Előkészítjük a lekérdezést: csak az ennél újabb üzeneteket kérjük, régitől az újig
if ($utolso === 0) {
    // Első betöltéskor a legutóbbi 200 üzenetet kérjük le, időrendben.
    $parancs = $kapcsolat->prepare("SELECT id, nev, szoveg FROM (SELECT id, nev, szoveg FROM uzenetek ORDER BY id DESC LIMIT 200) AS legutobbi ORDER BY id ASC");
} else {
    // Frissítéskor csak az újabb üzeneteket kérjük le.
    $parancs = $kapcsolat->prepare("SELECT id, nev, szoveg FROM uzenetek WHERE id > ? ORDER BY id ASC LIMIT 200");
    $parancs->bind_param("i", $utolso);
}
// Lefuttatjuk a lekérdezést
$parancs->execute();
// Elkérjük az eredményt
$eredmeny = $parancs->get_result();
// Egy üres tömböt készítünk, ebbe gyűjtjük az üzeneteket
$uzenetek = [];
// Végigmegyünk az eredmény minden során
while ($sor = $eredmeny->fetch_assoc()) {
    // Hozzáadjuk a sort a tömbhöz
    $uzenetek[] = $sor;
}
// Kiírjuk a tömböt JSON formátumban
echo json_encode($uzenetek);
