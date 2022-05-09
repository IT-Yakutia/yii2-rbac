Role Based Access Controll for yii2
===================================
Role Based Access Controll for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run
```
php composer.phar require --prefer-dist it-yakutia/yii2-rbac "*"
```
or add
```
"it-yakutia/yii2-rbac": "*"
```
to the require section of your `composer.json` file.

Add Module in backend config `main.php`:
```
return [
    ...
    'modules' => [
        ...
        'rbac' => \ityakutia\rbac\Module::class,
        ...
    ],
    ...
];
```

Add Component `authManager` in common config `main.php`:
```php
return [
    ...
    'components' => [
        ...
	    'authManager' => [
		    'class' => \yii\rbac\DbManager::class,
	    ],
	    ...
    ],
    ...
];
```

In console config `main.php` add `migrationPath` value in `controllerMap` `migration` section:
```php
return [
    ...
    'controllerMap' => [
        ...
	    'migrate' => [
		    'class' => \yii\console\controllers\MigrateController::class,
		    'migrationPath' => [
				'@console/migrations',
				...
			    '@yii/rbac/migrations',
			    ...
		    ],
	    ],
    ],
```

Usage
-----


Simply use it in your backend code by adding url on your navigation bar:

```php
Url::toRoute('/rbac/permission/index');
Url::toRoute('/rbac/role/index');
Url::toRoute('/rbac/user/index');
```

Controllers are allowed for user with permissions: `rbac_permissions`, `rbac_roles`, `rbac_users`