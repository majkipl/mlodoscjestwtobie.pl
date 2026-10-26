# mlodoscjestwtobie.pl — Platforma konkursowa & Landing Page

Profesjonalna platforma konkursowa z dedykowanym landing page oraz panelem administracyjnym do zarządzania zgłoszeniami konsumenckimi, kategoriami produktów, sklepami oraz weryfikacją dowodów zakupu.

Projekt jest w pełni skonteneryzowany przy użyciu **Dockera**, co zapewnia spójne i bezproblemowe środowisko uruchomieniowe.

---

## 🚀 Spis treści

- [Stos technologiczny](#-stos-technologiczny)
- [Wymagania wstępne](#-wymagania-wstępne)
- [Szybki start (Instalacja krok po kroku)](#-szybki-start-instalacja-krok-po-kroku)
- [Dostępne usługi i porty](#-dostępne-usługi-i-porty)
- [Domyślne konta testowe](#-domyślne-konta-testowe)
- [Architektura i kluczowe funkcjonalności](#-architektura-i-kluczowe-funkcjonalności)
- [Codzienna praca i przydatne polecenia](#-codzienna-praca-i-przydatne-polecenia)
- [Rozwiązywanie problemów (Troubleshooting)](#-rozwiązywanie-problemów-troubleshooting)

---

## 🛠 Stos technologiczny

### Backend & Baza danych
- **PHP**: `7.2.5`
- **Framework**: [Laravel 5.8](https://laravel.com/docs/5.8)
- **Baza danych**: [MySQL 5.7](https://dev.mysql.com/doc/refman/5.7/en/)
- **Menedżer pakietów**: [Composer](https://getcomposer.org/)

### Frontend
- **Szablony**: Blade
- **CSS / JS**: Bootstrap 4, jQuery 3, Sass
- **Bundler**: Laravel Mix (Webpack)

### Narzędzia deweloperskie & Infrastruktura
- **Docker & Docker Compose** — konteneryzacja całego środowiska (Apache, PHP, MySQL, phpMyAdmin, MailCatcher)
- **phpMyAdmin** — webowy interfejs do zarządzania bazą danych
- **MailCatcher** — lokalny serwer SMTP z podglądem wysłanych wiadomości e-mail w przeglądarce

---

## 📋 Wymagania wstępne

Przed uruchomieniem upewnij się, że masz zainstalowane:
- **Docker Engine** (wersja 20.10 lub nowsza)
- **Docker Compose** (wtyczka `docker compose` v2 lub narzędzie `docker-compose`)
- Opcjonalnie: **Node.js** i **NPM** (jeśli kompilujesz assety lokalnie poza kontenerem)

---

## ⚡ Szybki start (Instalacja krok po kroku)

### 1. Klonowanie repozytorium
```bash
git clone <adres-repozytorium>
cd mlodoscjestwtobie.pl
```

### 2. Konfiguracja środowiska
Skopiuj plik przykładowy `.env.example` do pliku produkcyjnego/lokalnego `.env`:
```bash
cp .env.example .env
```
Dostosuj wartości w pliku `.env` według własnych preferencji (m.in. porty kontenerów, poświadczenia bazy danych).

### 3. Zbudowanie i uruchomienie kontenerów
Uruchom kontenery w tle za pomocą Dockera:
```bash
docker compose up -d --build
```

Podczas pierwszego uruchomienia skrypt `entrypoint.sh` automatycznie wykona w kontenerze `httpd`:
- Instalację zależności Composera (`composer install`),
- Wygenerowanie unikalnego klucza aplikacji (`php artisan key:generate`),
- Utworzenie struktury bazy danych oraz załadowanie danych początkowych (`php artisan migrate:fresh --seed`),
- Wyczyszczenie pamięci podręcznej i konfiguracji (`cache:clear`, `config:clear`, `route:clear`),
- Utworzenie dowiązania symbolicznego dla plików storage (`public/storage`).

---

## 🌐 Dostępne usługi i porty

Domyślne mapowanie portów (definiowane w pliku `.env`):

| Usługa | URL / Port | Opis |
| :--- | :--- | :--- |
| **Aplikacja WWW** | [http://localhost:8300](http://localhost:8300) | Główna strona akcji i panel administracyjny |
| **phpMyAdmin** | [http://localhost:8302](http://localhost:8302) | Narzędzie do zarządzania bazą MySQL |
| **MailCatcher Web** | [http://localhost:8308](http://localhost:8308) | Podgląd e-maili testowych w przeglądarce |
| **Baza MySQL** | `localhost:8301` | Bezpośredni dostęp do portu MySQL |
| **MailCatcher SMTP**| `localhost:8307` | Port serwera SMTP dla aplikacji |

> [!NOTE]
> Jeżeli w Twoim pliku `.env` zdefiniowano inne porty (np. `DOCKER_HTTPD_PORT=8310`), użyj portów wskazanych w konfiguracji.

---

## 🔐 Domyślne konta testowe

Po wykonaniu seedera (`UserSeeder`) w systemie dostępne jest konto administratora:

- **Panel administracyjny**: [http://localhost:8300/panel](http://localhost:8300/panel)
- **E-mail**: `admin@example.com`
- **Hasło**: `asd123`

---

## 🏗 Architektura i kluczowe funkcjonalności

### Część publiczna (Frontend)
- **Landing Page**: prezentacja nagród, zasad promocji, produktów biorących udział w akcji oraz zwycięskich zgłoszeń tygodnia.
- **Formularz zgłoszeniowy** (`/formularz`):
  - Wprowadzenie danych uczestnika,
  - Wybór sklepu oraz zakupionych produktów,
  - Wgrywanie skanu/zdjęcia paragonu lub dowodu zakupu,
  - Zgody marketingowe i akceptacja regulaminu.
- **Weryfikacja e-mail** (`/potwierdzam/{id}/{token}`): potwierdzenie autentyczności zgłoszenia drogą mailową.
- **Formularz kontaktowy** (`/kontakt`): obsługa zapytań użytkowników z wysyłką powiadomień.

### Panel zarządzania (Backend)
Dostępny po zalogowaniu na konto z uprawnieniami administratora:
- **Zgłoszenia**: przegląd listy nadesłanych prac, podgląd szczegółów (dane osobowe, wgrany paragon, kwoty zakupu), statusy akceptacji.
- **Kategorie**: zarządzanie kategoriami produktów biorących udział w promocji.
- **Produkty**: dodawanie, edycja i usuwanie produktów objętych promocją.
- **Sklepy**: konfiguracja sieci handlowych i punktów sprzedaży.

---

## 💻 Codzienna praca i przydatne polecenia

Wszystkie komendy wykonujemy za pomocą `docker compose`:

### Kontrola kontenerów
```bash
# Uruchomienie kontenerów w tle
docker compose up -d

# Zatrzymanie kontenerów
docker compose down

# Przeglądanie stanu usług
docker compose ps

# Podgląd logów aplikacji w czasie rzeczywistym
docker compose logs -f httpd
```

### Polecenia Artisan i Composer
```bash
# Dostęp do powłoki kontenera aplikacji
docker compose exec httpd bash

# Uruchomienie migracji i seederów od nowa
docker compose exec httpd php artisan migrate:fresh --seed

# Czyszczenie pamięci podręcznej aplikacji
docker compose exec httpd php artisan cache:clear
docker compose exec httpd php artisan config:clear
docker compose exec httpd php artisan view:clear

# Interaktywna konsola Laravel Tinker
docker compose exec httpd php artisan tinker
```

### Uruchamianie testów
Projekt zawiera testy PHPUnit:
```bash
docker compose exec httpd ./vendor/bin/phpunit
```

### Kompilacja assetów (Frontend)
W przypadku modyfikacji stylów SCSS lub skryptów JS w katalogu `resources/`:
```bash
# Instalacja zależności NPM (na maszynie hosta)
npm install

# Kompilacja deweloperska z nasłuchiwaniem zmian
npm run watch

# Budowanie wersji produkcyjnej
npm run production
```

---

## 🔧 Rozwiązywanie problemów (Troubleshooting)

### 1. Błąd 404 podczas `apt-get update` przy budowaniu obrazu
Wydania Debiana używane w starszych obrazach PHP (Debian Buster/Stretch) zostały przeniesione do archiwum (`archive.debian.org`). Konfiguracja w pliku `docker/apt/sources.list` została dostosowana i zawiera aktualne adresy archiwalne z flagą `[check-valid-until=no]`.

### 2. Błąd połączenia z bazą danych przy pierwszym starcie
Podczas pierwszego uruchomienia kontener MySQL inicjalizuje pliki bazy danych, co może zająć kilkanaście sekund. Jeśli kontener `httpd` wystartuje szybciej i nie zdoła wykonać migracji, wystarczy uruchomić je ręcznie po ustabilizowaniu bazy:
```bash
docker compose exec httpd php artisan migrate:fresh --seed
```

### 3. Uprawnienia do katalogów `storage` i `bootstrap/cache`
Kontener automatycznie nadaje uprawnienia użytkownikowi `www-data`. W razie problemów z zapisem sesji, logów lub plików uploadowanych na hoście Linux:
```bash
chmod -R 777 storage bootstrap/cache
```

---

## 📄 Licencja

Projekt oparty na frameworku Laravel, dystrybuowany na licencji [MIT](https://opensource.org/licenses/MIT).
