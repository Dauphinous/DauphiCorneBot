# Skinny Plugin Installer

|StyleCI|License|
|:------:|:------:|
|[![StyleCI](https://styleci.io/repos/73428628/shield)](https://styleci.io/repos/73428628)|[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/skinnybot/skinny-skeleton)|

A composer installer for installing Skinny plugins.

## Usage
Your plugins themselves do not need to require `skinny/plugin-installer`. They only need to specify the type in their composer config :
```
"type": "skinny-plugin"
```
