<?php

namespace ityakutia\rbac;

class Bootstrap implements \yii\base\BootstrapInterface {

	/**
	 * @inheritdoc
	 */
    public function bootstrap($app)
    {
	    if ($app instanceof \yii\console\Application) {
		    if (empty($app->controllerMap['migrate'])) {
			    $app->controllerMap['migrate'] = [
				    'class' => \yii\console\controllers\MigrateController::class
			    ];
		    }

		    if (empty($app->controllerMap['migrate']['migrationPath'])) {
			    $app->controllerMap['migrate']['migrationPath'] = ['@console/migrations'];
		    }

		    $app->controllerMap['migrate']['migrationPath'] = array_merge(
			    $app->controllerMap['migrate']['migrationPath'],
			    ['@yii/rbac/migrations']
		    );
	    }

		if ($app->id == 'backend') {
			$app->setModule('rbac', \ityakutia\rbac\Module::class);
			$app->getUrlManager()->addRules([
				'rbac' => 'rbac/user/index',
			], false);
		}
    }
}