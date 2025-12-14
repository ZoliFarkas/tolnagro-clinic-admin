Telepítési útmutató

Klónozás:

git clone https://github.com/ZoliFarkas/tolnagro-clinic-admin.git
cd tolnagro-clinic-admin


Composer telepítés:

composer install


Környezeti fájl:

cp .env.example .env


.env adatbázis beállítás:

(itt be lehet állítani a SESSION_DRIVER-t "file"-ra így nem dob majd hibát.)

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinic
DB_USERNAME=root
DB_PASSWORD=


App kulcs:

php artisan key:generate


Migrációk lefuttatása:

php artisan migrate


Seeder futtatása:

php artisan db:seed


Szerver indítása:

php artisan serve


Elérés:
http://127.0.0.1:8000

EXTRA FUNKCIÓK A FELADAT KÖVETELMÉNYEIN TÚL

1. Vizitek teljes körű kezelése (CRUD)
- Új vizit létrehozása, szerkesztése, törlése
- Megerősítéssel ellátott törlés
- Automatikus visszairányítás mentés után

2. Önálló Vizitek oldal
- Külön oldal a vizitek kezelésére
- Beteg kiválasztása legördülő listából
- Dinamikus lista frissítés

3. Időszak alapú szűrés
- Előre definiált időszakok (7 nap, 30 nap, idei év)
- Kontextusérzékeny megjelenítés

4. CSV export funkció
- Excel-kompatibilis CSV export
- UTF-8 BOM az ékezetekhez
- Export csak releváns állapotban engedélyezett
- Backend oldali ellenőrzés

5. Reszponzív megjelenítés
- Asztali nézetben táblázat
- Mobil nézetben kártyás lista

6. UX és architekturális kiegészítések
- Kétszintű navigáció
- Aktív menüpont kiemelés
- Üres állapotok kezelése
- Eloquent casting és tiszta MVC struktúra

