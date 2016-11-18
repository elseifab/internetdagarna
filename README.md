# Automatisk hantering för WordPress-projekt
WordCamp Internetdagarna, Waterfront Stockholm, 2016

Denna kodbas är framtagen för presentationen på WordCamp 2016.

Presentationen är uppdelad i X antal steg och varje steg är en version i Git.
Du kan alltså stegvis följa med i kodens förändringar för att nå slutmålet.

Koden är upplagd för att visa på WordPress i Composer, deployment och initialt test.
Detta för att göra ett "proof-of-concept" på en strukturerad miljö för utveckling och distribution av WordPress-projekt.

[Denna presentation sammanfattas i slides här!](https://www.elseif.se/internetdagarna)

Syftet är att ge en inblick och förståelse för hur utveckling med WordPress kan automatiseras och göras med kontrollerat upplägg med versionshantering, pakethantering, deployment och test.
Naturligtvis är detta bara en grund och ingen slutgiltig lösning.

Vi förutsätter att du har en dator med PHP installerat. Företrädesvis version 7.

## Versionshantering
Git används för versionshantering. Installera [Git](https://git-scm.com/downloads) på din dator!
Projektet ligger på Github med licens MIT. 

## Pakethantering
Vi använder [Composer](https://getcomposer.org/), styrfilen för externa paket finns definierade i composer.json.
```
composer install
```
Ta för vana att köra `composer update` för att dina externa paket ska vara uppdaterade.

## Utvecklingsmiljön
[Vagrant](https://www.vagrantup.com/) med [Virtual Box](https://www.virtualbox.org/)

[Homstead Laravel](https://laravel.com/docs/5.3/homestead)

```
composer update
```

```
composer require laravel/homestead --dev
php vendor/bin/homestead make
```
Redigera Homestead.yaml till med dina inställningar.
Uppdatera /etc/hosts (OSX)
```
vagrant up
```
