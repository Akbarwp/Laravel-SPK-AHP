# Laravel SPK AHP

Laravel SPK AHP is a website designed to provide a decision support system using the AHP (Analytic Hierarchy Process) method. This site enables users to analyze various decision alternatives based on defined criteria, assisting in determining the best choice in a systematic and transparent way. With a user-friendly interface, users can easily input data and obtain in-depth analysis results to support more accurate decision-making.

## Tech Stack

- **Laravel 9** --> **Laravel 12**
- **Laravel Breeze**
- **MySQL Database**
- **TailwindCSS**
- **daisyUI**
- **[maatwebsite/excel](https://laravel-excel.com/)**
- **[barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)**

## Features

- Main features available in this application:
  - Implementation AHP method
  - Import data --> example [Kriteria](https://github.com/user-attachments/files/19679422/Import.Kriteria.xlsx), [Kategori](https://github.com/user-attachments/files/19679419/Import.Kategori.xlsx)

## Installation

Follow the steps below to clone and run the project in your local environment:

1. Clone repository:

    ```bash
    git clone https://github.com/Akbarwp/Laravel-SPK-AHP.git
    ```

2. Install dependencies use Composer and NPM:

    ```bash
    composer install
    npm install
    ```

3. Copy file `.env.example` to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Setup database in the `.env` file:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_ahp
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Run migration database:

    ```bash
    php artisan migrate
    ```

7. Run seeder database:

    ```bash
    php artisan db:seed
    ```

8. Run website:

    ```bash
    npm run dev
    php artisan serve
    ```

## Screenshot

- ### **Dashboard**

<img src="https://github.com/user-attachments/assets/cce7a649-59d8-47b5-ba94-70e0aa98b4ca" alt="Halaman Dashboard" width="" />
<br><br>

- ### **Criteria page**

<img src="https://github.com/user-attachments/assets/c52dceb4-7c4c-4bad-8d3c-093e52013656" alt="Halaman Kriteria" width="" />
<br><br>
<img src="https://github.com/user-attachments/assets/54bbaf8f-ed9c-4ffa-9bf7-2bd2dba694ef" alt="Halaman Kriteria" width="" />
<br><br>

- ### **Penilaian page**

<img src="https://github.com/user-attachments/assets/0c412a06-1c8d-42be-885f-21a9cb0e1acc" alt="Halaman Penilaian" width="" />
<br><br>

- ### **Result page**

<img src="https://github.com/user-attachments/assets/db40f871-861c-4a40-bf23-f1cd226b2093" alt="Halaman Hasil Akhir" width="" />
<br><br>
