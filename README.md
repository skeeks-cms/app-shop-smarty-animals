Магазин на базе SkeekS CMS (yii2 cms)
================

[![skeeks!](http://cms.skeeks.com/uploads/all/02/bb/d1/02bbd1ed904fc44bdee66e33b661cf2c/sx-filter__skeeks-cms-components-imaging-filters-Thumbnail/15f3c42a5e338e459b5bfe72f1874494/sx-file.png?w=409&h=258)](http://cms.skeeks.com)  

##Info

* [Сайт о SkeekS CMS (about)](http://cms.skeeks.com)
* [Докуметация (wiki)](http://dev.cms.skeeks.com/docs)
* [Установка (install)](http://dev.cms.skeeks.com/docs/dev/ustanovka-nastroyka-konfigurirov/ustanovka-s-ispolzovaniem-composer)

Installation
------------

```bash
# Download latest version of composer
curl -sS https://getcomposer.org/installer | COMPOSER_HOME=.composer php

# Installing the base project SkeekS CMS
COMPOSER_HOME=.composer php composer.phar create-project --prefer-dist --stability=dev skeeks/app-shop-smarty-animals demo.ru
# Going into the project folder
cd demo.ru

#Edit the file to access the database, it is located at common/config/db.php

#Installation of ready-dump
php yii dbDumper/mysql/restore
```

##Backend (username and password by default)

http://your-site.ru/~sx

root

skeeks

___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — quickly, easily and effectively!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)
