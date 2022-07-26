# Hackathon Apside June 2022
Hackathon organisé par l'entreprise Apside sur une durée de 3 jours. 

---

Requirements :

php 7.x (mini)
composer
yarn
symfony cli
To setup the project :

`$ yarn install`

`$ composer install`

Make a copy of the .env file

`$ cp .env .env.local`

Then change the DATABASE_URL with the correct informations.

Create the database :

`$ php bin/console doctrine:database:create`

`$ symfony server:start -d`

`$ yarn encore dev-server`

When you pull back code you'll need to update database schema and load the fixtures :

`$ php bin/console doctrine:migrations:migrate`

`$ php bin/console doctrine:fixtures:load`

Nb: to add more and more packages use yarn instead of npm

---

Demo login :

id: user0@gmail.com

pswd : password

---

Projet made with ❤️ with Symfony
