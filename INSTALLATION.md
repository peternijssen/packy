Production Installation
=====
- Point Apache/NGINX to web/app.php
- Make sure a correct database connection has been set in `app/config/parameters.yml`
- Run `php app/console packy:install --env=prod` to install Packy
- Set a cronjob for `php bin/console packy:project:update --env=prod` and `bin/console packy:package:update --env=prod`

Development Installation
=====

- install gulp `npm install gulp`
- install gulp dependencies `npm install `
- run `gulp watch` to get assets
- Run `composer install` to install php dependencies
- Make sure a database connection has been set in `app/config/parameters.yml`
- Run `php app/console packy:install`

