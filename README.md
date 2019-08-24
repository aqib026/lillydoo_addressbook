============

A Symphony project created using symphony framework 3.4


PHP version required is 7.2


## Project setup & running

```
git clone git@github.com:aqib026/address_book.git
cd address_book
composer install
php bin/console server:start
```



## Testing

```
php ./vendor/phpunit/phpunit/phpunit tests/AppBundle/Controller/AddressBookControllerTest.php

```

##Window Virtual Host Setting


```
<VirtualHost *:80>
    DocumentRoot "directory-where-code-is-checkout/web/"
    ServerName servername-of-your-choice.loc
    ServerAlias www.servername-of-your-choice.loc
    DirectoryIndex /app_dev.php
    <Directory directory-where-code-is-checkout/web/>
        AllowOverride None
        Order Allow,Deny
        Allow from All

        FallbackResource /app_dev.php
    </Directory>

</VirtualHost>
```