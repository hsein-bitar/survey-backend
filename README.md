# surveys
A website to build surveys, and share them to get answers
<hr width=33% align=left color=red>

## Version
1.0.0

<h2>Usage</h2>

<hr align=left color=red>

## 1 - Clone this repo, the laravel backend
### 1.a For faster setup, copy the .env.example contents into .env
### 1.b Install the dependencies

```sh
$ composer install
```
### 1.c Create database "surveydb" using XAMPP phpMyAdmin user interface
### 1.d Run the included migrations
```sh
$ php artisan migrate
```
### 1.e Get the Apache and mySQL servers running, then do:
```sh
$ php artisan serve
```
<hr width=33% align=left color=red>

### To test the frontend user interface: you should have NodeJS and NPM intstalled.
## 2 - Clone react app repo into your device: https://github.com/hsein-bitar/survey-frontend.git

### 2.a Install the dependencies
```sh
$ npm install
```
### 2.b Run Electron

```sh
$ npm start
```
<hr width=33% align=left color=red>