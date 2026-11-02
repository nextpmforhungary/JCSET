-- Létrehozzuk az adatbázist, ha még nem létezik
CREATE DATABASE IF NOT EXISTS jewcset CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;
-- Kiválasztjuk, hogy ebben az adatbázisban dolgozunk
USE jewcset;
-- Létrehozzuk az üzenetek táblát
CREATE TABLE IF NOT EXISTS uzenetek (
  -- Egyedi sorszám, automatikusan nő eggyel minden új üzenetnél
  id INT AUTO_INCREMENT PRIMARY KEY,
  -- A küldő neve (legfeljebb 50 karakter)
  nev VARCHAR(50) NOT NULL,
  -- Az üzenet szövege (legfeljebb 500 karakter)
  szoveg VARCHAR(500) NOT NULL,
  -- A küldés ideje, automatikusan kitöltődik
  ido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- A tábla vége, utf8mb4 kell az ékezetekhez
) CHARACTER SET utf8mb4;
