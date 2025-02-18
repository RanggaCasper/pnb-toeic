# PNB TOEIC

## Requirements
Before starting, ensure you have the following installed : 
- PHP >= 8.2
- Composer
- MySQL
- Git

### Installation
Follow the steps below to set up the Laravel 11 project on your local environment.

1. **Clone the Repository**

   ```bash
   git clone https://github.com/RanggaCasper/pnb-toeic.git
   cd pnb-toeic
   ```

2. **Install Composer Dependencies**
    ```bash
    composer install
    ```

3. **Setup Enviroment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure the Database**

    Open the ```.env``` file and update the database settings:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pnb_toeic
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Run Migrations and Seeders**
    ```bash
    php artisan migrate --seed
    ```

6. **Start the Development Server**
    ```bash
    php artisan serve
    ```
    The application will run at http://127.0.0.1:8000/.