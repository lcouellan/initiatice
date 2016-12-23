initiatice
==========

A Symfony project created on December 2, 2016, 2:32 pm.

# Install
1. Generate vendors and add database config
```
    php composer.phar install
```

2. Create tables
```
    php bin/console doctrine:schema:update
```

3. Generate fixtures
```
    php bin/console doctrine:fixtures:load
```

# Documentation

1. Generate a documentation for the API
```
phpdoc -d src/initiatice/ApiBundle/Controller/ -t docs/api
```

2. Visualise by opening the index.html file generated in docs/api
