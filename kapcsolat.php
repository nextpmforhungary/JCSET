<?php
// Létrehozzuk a kapcsolatot az adatbázissal: gép, felhasználó, jelszó, adatbázis neve
// (XAMPP-ban az alapértelmezett felhasználó a root, jelszó nélkül)
$kapcsolat = new mysqli("localhost", "root", "", "jewcset");
// Beállítjuk az UTF-8 kódolást, hogy az ékezetes betűk jól mentődjenek
$kapcsolat->set_charset("utf8mb4");
