# Laravel Test Intermediate

Didalam project ini terdapat Backend menggunakan Framework 
Laravel, dan Frontend menggunakan Framework VueJS alias Laravel x VueJS

Di dalamnya terdapat fitur API 
1. Login
2. Register
3. getData Kabupaten
4. getData list kunjungan

## Table of Contents

- [Project Overview](#project-overview)
- [Installation](#installation)
- [Usage](#usage)


## Project Overview

Didalam project ini menggunakan Laravel 9, Vuejs 3, dan Php Versi 8 

## Installation

Provide step-by-step instructions on how to install and set up your project. Include any dependencies that need to be installed and any additional configuration that needs to be done.

1. Clone repositori ini ke mesin lokal:
 ```bash
   git clone https://github.com/sulistyop/intermediate-laravel.git
```
2. Masuk ke direktori project
 ```bash
   cd intermediate-laravel
```
3. Instal semua dependensi menggunakan Composer dan NPM:
```bash
  composer install
  npm install
```
4. Salin berkas .env.example menjadi .env dan sesuaikan pengaturan database dan konfigurasi lain yang dibutuhkan:
    
```bash
  cp .env.example .env
```

5. Generate key aplikasi:
```bash
  php artisan key:generate
```
6. Buatlah 2 database sesuai nama dibawah ini:

    1. Database bernama `farmagitech` atau database punya anda , database ini adalah database utama dari aplikasi
    2. Database dgn nama `testing_fg`, database ini untuk menjalankan unit testing dari fitur yang sudah dibuat


7. Migrasikan basis data beserta seeder yang sudah disediakan:
```bash
  php artisan migrate:fresh --seed
```


## Usage

Jalankan server Backend menggunakan perintah :

```bash
  php artisan serve
```
Untuk menjalankan Frontend jalankan perintah :
```bash
  npm run dev
```

untuk Dokumentasi api diakses di "{server lokal anda}/api/docs":
```bash
  http://127.0.0.1:8000/api-docs
```

untuk Aplikasi nya diakses di:
```bash
  http://127.0.0.1:8000
```

Login yang sudah ada dalam seeder 
```bash
  admin@test.com
  password
```


Authentikasi menggunakan Bearer (Access Token) Keterangan ada di API DOCS
