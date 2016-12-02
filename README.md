initiatice
==========

A Symfony project created on December 2, 2016, 2:32 pm.

# Install
1. Generate vendors and add database config
    php composer.phar install

2. Create tables
    php bin/console doctrine:schema:update

3. Generate fixtures
    php bin/console doctrine:fixtures:load