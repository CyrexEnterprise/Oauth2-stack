# Oauth2 Stack
####A complete Oauth2 Server and Views stack

With the **Oauth2 Stack** one can integrate the complete Open Authentication 2.0 flow in a single require.
The package includes **DB** migration files, the **Oauth2 Server**, **Account/User models** and all the required **web** and **e-mail views**.

The goal of this package is to split it up in multiple Framework Branches. Right now, however, the Oauth2-Stack package is focussed on **Laravel 4.2 with Eloquent** in **MQ** alignment (3-layer environment).

##### Dependencies
**Oauth2 Server** - The Oauth2 Stack is based on [Brent Shaffer's Oauth2 Server](https://github.com/bshaffer/oauth2-server-php), tweaked for multi-layer usage.

**Views** - The Views are based on [Bootstrap 3](http://getbootstrap.com) for easy styling.

---
For this package, you should have some knowledge of Composer and Laravel.
If you need your local environment set up, read [this guide](http://blog.cloudoki.com/set-up-your-local-battleground/). If you want a simple Laravel app set up, read [this guide](http://blog.cloudoki.com/basic-blog-structure-in-laravel-angularjs/).

---

##Laravel 5.2 MQ Install
Add our package as requirement in your composer file.
```
$ nano composer.json
```
```
"require": {
    "laravel/framework": "5.2.*",
    "cloudoki/oauth2-stack": "dev-master"
    ...
```
You might want to run an update. If something goes wrong, change your `minimum-stability` to `dev` in the `composer.json` file, for now.
```
$ composer update
```

The package is now installed in the project `vendor` folder. You'll need to register the package provider in your app config file next.
Since Laravel 5, the Illuminate\Form is no longer part of the core pack, so you should register it as well.
```
$ nano config/app.php
```
```
	'providers' => [
		...
		Collective\Html\HtmlServiceProvider::class,
		Cloudoki\OaStack\OaStackServiceProvider::class,
    ],

	'aliases' => [
		...
        'Form'		=> Collective\Html\FormFacade::class,
        'HTML'		=> Collective\Html\HtmlFacade::class,
    ],
```


##Laravel 4.2 MQ Install
Add our package as requirement in your composer file.
```
$ nano composer.json
```
```
"require": {
    "laravel/framework": "4.2.*",
    "cloudoki/oauth2-stack": "v0.4"
    ...
```
You might want to run an update. If something goes wrong, change your `minimum-stability` to `dev` in the `composer.json` file, for now.
```
$ composer update
```

The package is now installed in the project `vendor` folder. You'll need to register the package provider in your app config file next. Finish it off with dump to be on the safe side.
```
$ nano app/config/app.php
```
```
'providers' => array(
    ...
    'Cloudoki\OaStack\OaStackServiceProvider'
),
```
```
$ php artisan dump-autoload
```

If you go deep into the package you'll find out that the `/oauth2` routes are defined right there.
Feel free to override this by copy-pasting the routes to your project `./app/routes.php` file and disabling the include in `OaStackServiceProvider.php`. The same goes for the filters file, which identifies `auth`, a basic token check.

#### Config
You will need to edit the uri's to match your project. We have created a config file for this purpose. Run this command to copy it in your .app/config folder:

**Laravel 4.2**
```
$ php artisan config:publish cloudoki/oauth2-stack
```
*You may also create environment specific configs by placing them like so `app/config/packages/cloudoki/oastack/environment`.*

**Laravel 5.2**
```
$ php artisan vendor:publish
```
*This will publish the package and everything in the boot method on the pacakage ServiceProvider file*

Note that your `app/config/app.php` file needs a valid timezone setting.
```
'timezone' => 'Europe/Brussels'
```

#### Models
The Oauth2 related models, **Oauth2AccessToken**, **Oauth2Authorization**, **Oauth2Client** should be created into your database straight from the migration files. The User and Account models can be integrated (eg. by class extending) in your existing project, or also be built straight from the migration files.

**Laravel 4.2**
```
$ php artisan migrate --package="cloudoki/oauth2-stack"
```

**Laravel 5.2**
```
$ php artisan vendor:publish --tag="migrations"
```

*Make sure your project database is connected, first...*


This package is all [MIT](http://opensource.org/licenses/MIT).
