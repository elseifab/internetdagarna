# Automatisk hantering för WordPress-projekt
WordCamp Internetdagarna, Waterfront Stockholm, 2016

Denna kodbas är framtagen för presentationen på WordCamp Stockholm 2016.

Koden ska ses som ett "proof-of-concept" på en strukturerad miljö för utveckling och distribution av WordPress-projekt.

[Denna presentation sammanfattas i slides här!](https://www.elseif.se/internetdagarna)

Syftet är att ge en inblick och förståelse för hur utveckling med WordPress kan automatiseras och göras med kontrollerat upplägg med versionshantering, pakethantering, deployment och test.

## Länkar efter presentationen
Några frågor kring presentationen visade på intressanta uppslag:

[Roots](https://roots.io/): [Trellis - Vagrantmiljö](https://roots.io/trellis/), [Bedrock - paketstruktur](https://roots.io/bedrock/), [Sage - tema](https://roots.io/sage/)
[Laravel Forge](https://forge.laravel.com/), funkar fint för denna typ av WordPress-upplägg.

## Grundkrav
* PHP
* Composer
* Git
* Virtual Box
* Vagrant

### Option
* Node, npm för testcase i CasperJS
* En VPS att leverera till

## Snabba steg
Om du vill få detta att rulla med snabba steg:

* `composer create-project elseif/internetdagarna`
* `cd internetdagarna`
* `cp .env.example .env`
* (modifiera Homestead.yaml rad 15 till ditt projekts sökväg)
* `vagrant up`
* (modifiera hosts-filen med: 192.168.10.13 => internetdagarna.dev)
* `vendor/bin/dep` initial dev
* (surfa till http://internetdagarna.dev)

Mer om varje del nedan!

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
Krånglar miljön? Starta om Vagrantboxen:
```
vagrant reload --provision
```

## Deployment
Vi använder [PHP Deployer](https://deployer.org/) och [WP CLI](https://wp-cli.org/) för att initiera ny webbplats.
```
vendor/bin/dep initwp dev
```
Initierar WordPress-installation i din Vagrantbox samt sätter ett testtema som aktivt.

Logga in i wp-admin: [`http://internetdagarna.dev/wp/wp-admin`](http://internetdagarna.dev/wp/wp-admin) med `admin` och lösenord `admin`.

```
vendor/bin/dep testdata dev
```
Fyller din WordPress-webbplats med testdata.

## Test
Vi använder [PHPUnit](https://phpunit.de/) och i detta fall ett mycket enkelt UI-test med hjälp av [CasperJS](http://casperjs.org/) som genererar en bild på testet.
CaperJS kräver [Node](https://nodejs.org/en/) i global installation.

Selenium (Javabaserat) är ett annat verktyg för UI-test men eftersom vi ofta ändå använder Node så är CasperJS närmare till hands och dessutom betydligt enklare.


Installationsexempel:
```
sudo npm install -g phantomjs
sudo npm install -g casperjs
```

```
vendor/bin/dep tests dev
```
Drar igång UI-test i din Vagrantbox.

## Deployment Production
```
vendor/bin/dep deploy production
```
Skapar en ny release på produktionsservern. Grundkraven är att destinationen har Git och Composer installerat.
Vidare behöver en shared/.env samt installerad databas. Det går att initiera WordPressinstallationen med tidigare `startup`, ex:
```
vendor/bin/dep startup production
```
Observera att databas och .env måste finnas på servern. Kom ihåg att ändra admin-lösenordet!
