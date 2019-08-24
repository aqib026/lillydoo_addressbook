============

A Symphony project created using symphony framework 3.4


PHP version required is 7.2


## Project setup & running

```
git clone https://github.com/aqib026/lillydoo_addressbook.git
cd lillydoo_addressbook
composer install
php bin/console server:start
```



## Testing

```
php ./vendor/phpunit/phpunit/phpunit tests/AppBundle/Controller/AddressBookControllerTest.php

```

##Window Virtual Host Setting , in case you use apache server 


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