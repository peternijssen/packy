Production Installation
=====
- Point Apache/NGINX to web/app.php
- install npm dependencies `npm install`
- run `./node_modules/.bin/encore prod` to get assets
- Run `composer install` to install php dependencies
- Run `php bin/console packy:install --env=prod` to install Packy
- Set a cronjob for `php bin/console packy:project:update --env=prod` and `bin/console packy:package:update --env=prod`

Development Installation
=====
- Point Apache/NGINX to web/
- install npm dependencies `npm install`
- run `./node_modules/.bin/encore dev` to get assets
- Run `composer install` to install php dependencies
- Make sure a database connection has been set in `app/config/parameters.yml`
- Run `php bin/console packy:install`

