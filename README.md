# WCS_LiveCoding_S5_MVC_PDO
[![Donate](https://img.shields.io/badge/Donate-PayPal-brightgreen.svg?style=flat-square&logo=paypal)](https://paypal.me/PaulDSB/)

About
------------
Live coding with PDO / MVC and form with errors handling

Language && software used
--------------
[![Language](https://img.shields.io/badge/Language-Php-red.svg?style=flat-square)][1]
[![PhpStorm](https://img.shields.io/badge/Software-PHPStorm-ff69b4.svg?style=flat-square&colorB=B356EA)][2]

Installation
-------------
1. Connect to mysql with your **username** and your **password** and create a new database:
    - `mysql -u USERNAME -p`
    - Write your password
    - `CREATE DATABASE nameDatabase;`
    - `exit;`

2. Import the database with the commande line:
    - `mysql -u username -p nameDatabase < dump.sql`

3. Go to the project `cd ~/path_to_my_project`

4. Rename `connect.php.dist` >> `connect.php`

5. Go to your project and configure the variables:
    - `$db_name` (Same name when creating the database)
    - `$db_username`
    - `$db_password`

5. Do `composer install` to install dependancies
6. Start your server
    - `php -S localhost:8000 -t public/`

Enjoy ;)

[1]: http://php.net/manual/en/intro-whatis.php
[2]: https://www.jetbrains.com/phpstorm/