# Skinny Skeleton

|Travis|Scrutinizer|StyleCi|Stable Version|Downloads|License|
|:------:|:-------:|:-------:|:-------:|:------:|:------:|
|[![Build Status](https://img.shields.io/travis/SkinnyBot/Skinny-Skeleton.svg?style=flat-square)](https://travis-ci.org/SkinnyBot/Skinny-Skeleton)|[![Scrutinizer](https://img.shields.io/scrutinizer/g/SkinnyBot/Skinny-Skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/SkinnyBot/Skinny-Skeleton)|[![StyleCI](https://styleci.io/repos/73373872/shield)](https://styleci.io/repos/73373872)|[![Latest Stable Version](https://img.shields.io/packagist/v/SkinnyBot/Skinny-Skeleton.svg?style=flat-square)](https://packagist.org/packages/skinnybot/skinny-skeleton)|[![Total Downloads](https://img.shields.io/packagist/dt/skinnybot/skinny-skeleton.svg?style=flat-square)](https://packagist.org/packages/skinnybot/skinny-skeleton)|[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/skinnybot/skinny-skeleton)

The bot skeleton used for [Skinny](https://github.com/SkinnyBot/Skinny).

The source code of the bot core can be found here: [SkinnyBot/Skinny](https://github.com/SkinnyBot/Skinny).

# Requirements
* :package: [Composer](https://getcomposer.org)
* ![PHP](https://img.shields.io/badge/PHP->=5.6-44CB12.svg?style=flat-square)

# Installation
 * `composer create-project --prefer-dist skinnybot/skinny-skeleton <application_name>`
 * Rename the file `config/config.default.php` to `config/config.php`
 * Configure your bot token in the file `config/config.php`

# Run
Command line only : `php run.php`

# Note
The skeleton will install by default the [Module Plugin](https://github.com/SkinnyBot/Module) and the [Basic Plugin](https://github.com/SkinnyBot/Basic) automatically.

## Running the bot permanently on a Server
I recommend to use the popular `Unitech/pm2` npm package to run your bot. You will need `NodeJS` and `npm` installed on your server.
```
# Using Ubuntu
curl -sL https://deb.nodesource.com/setup_7.x | sudo -E bash -
sudo apt-get install -y nodejs

# Using Debian, as root
curl -sL https://deb.nodesource.com/setup_7.x | bash -
apt-get install -y nodejs


# Then
sudo npm install pm2@latest -g
pm2 start run.php -n "skinny"
```
More informations on the `pm2` package can be found on the [Unitech/PM2](https://github.com/Unitech/pm2) repository.

More informations about installing NodeJS can be found [here](https://github.com/nodesource/distributions).


# Contribute
[Follow this guide to contribute](https://github.com/SkinnyBot/Skinny-Skeleton/blob/master/.github/CONTRIBUTING.md)
