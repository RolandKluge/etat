etat
====

Web-based book of household accounts

Setup
=====
 * Setup a database for the application, note down username, password, host(, UNIX socket, encoding)
    - The folder ./sql contains the SQL schema (exported from MySQL)
    - In order to import it, e.g.
mysql -u <db-user> -p --socket=/tmp/mysql5.sock <db-name> < ./sql/etat.sql



 * In ./config, create a file configure.php that is a copy of configure.php.template
    - Setup database DSN, DB user, DB password, and the absolute path to this project's root
    - Example DSN:
mysql:host=localhost;unix_socket=/tmp/mysql5.sock;dbname=db1234;charset=utf8
    
    
    
 * If necessary create a .htaccess file
    - If desired: Access control via .htpasswd
        -> htpasswd -c .htpasswd user1
        -> htpasswd .htpasswd user2 # etc
        -> Add the following to .htaccess
AuthUserFile <absolute-path-to-.htpasswd>
AuthName "Please log in!"
AuthType Basic
Require valid-user
    - If necessary: Further instructions to select the proper PHP version etc.
        -> For 1&1:
AddType x-mapp-php5 .php 
AddHandler x-mapp-php5 .php
        -> If necessary: 
DirectoryIndex: index.php

