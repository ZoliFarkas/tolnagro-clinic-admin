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
