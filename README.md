initiatice
==========

A Symfony project created on December 2, 2016, 2:32 pm.

# Install
Generate vendors and add database config
```
    php composer.phar install
```

Create tables
```
    php bin/console doctrine:schema:update
```

Generate fixtures
```
    php bin/console doctrine:fixtures:load
```

# Documentation

Generate a documentation for the API
```
phpdoc -d src/initiatice/ApiBundle/Controller/ -t docs/api
```

Visualise by opening the index.html file generated in docs/api
