Packy [![Build Status](https://scrutinizer-ci.com/g/peternijssen/packy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/peternijssen/packy/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/peternijssen/packy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/peternijssen/packy/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/peternijssen/packy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/peternijssen/packy/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/d43bceaf-afaa-48fd-99ce-52cb437e5d73/mini.png)](https://insight.sensiolabs.com/projects/d43bceaf-afaa-48fd-99ce-52cb437e5d73)
=====

**Description**

Packy is an open source tool to validate if your dependencies are up 2 date. Packy is still in development and is not production ready yet.

**Current analyzers**
- Composer
- Npm
- Pip
- Bower

Screenshots
=====

![Packy](http://i60.tinypic.com/2mgtxdj.png)

![Packy](http://i61.tinypic.com/es98o3.png)

![Packy](http://i58.tinypic.com/2ptdz5y.png)

Installation
=====

Packy is not production ready yet. However, if you want to install it already or you want to contribute, follow these steps:
- install gulp `npm install gulp`
- install gulp dependencies `npm install `
- run `gulp watch` to get assets
- Run `composer install` to install php dependencies
- Make sure a database connection has been set in `app/config/parameters.yml`
- Run `php app/console packy:install`

Contributing
=====

Thanks for considering to contribute. You can contribute by creating pull requests or report issues.

Translating
=====

Currently, no language files have been created. Feel free to help out. When done, translating Packy will become possible.

Authors
=====

Packy was originally created by [Peter Nijssen](https://www.peternijssen.nl).
See the list of [contributors](https://github.com/peternijssen/packy/graphs/contributors).

The theme is named [AdminLTE](https://github.com/almasaeed2010/AdminLTE) and is created by [Almsaeed Studio](http://www.almsaeedstudio.com/).
