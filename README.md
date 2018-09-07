Demo task - Image Uploader
==========================

Demo task for uploading image files using PHP 7 and Symfony 3.4 framework.

System Requirements
-------------------

* PHP 7.0.8+;
* SQLite 3.0+;
* Composer.

Installation instructions
-------------------------

1. Install the prerequisites (PHP, SQLite, etc...);
2. Install project dependencies using composer

   ```
   composer install
   ```

3. Create database and schemas in it

   ```
   php bin/console doctrine:database:create
   php bin/console doctrine:schema:create
   ```

4. Start PHP server

   ```
   php bin/console server:run
   ```

5. Open browser and visit server url (probably http://localhost:8000).


Building frontend assets
---------------

1. Install *node.js* and *yarn*.
2. Install dependencies using yarn

   ```
   yarn install
   ```

3. Use Symfony Encore to build assets

   ```
   # For development
   yarn encore dev --watch

   # For production
   yarn encore production
   ```

License
-------

All code is licensed under [MIT](LICENSE) license.
