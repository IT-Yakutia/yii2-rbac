<?php

namespace ityakutia\rbac\models;

use Yii;
use yii\base\Model;
use yii\db\IntegrityException;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\rbac\Item;

/**
 * ContactForm is the model behind the contact form.
 */
class PermissionForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['name', 'description'], 'trim', 'skipOnEmpty' => true],
            [['name', 'description'], 'filter', 'skipOnEmpty' => true, 'filter' => function($value) { return strip_tags($value); }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Идентификатор",
            'description' => "Название",
        ];
    }

    public function all()
    {
        $auth = Yii::$app->authManager;

        $query = (new Query())->from($auth->itemTable)->where(['type' => Item::TYPE_PERMISSION]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name', 'description'],
            ],
        ]);

        $query->andFilterWhere(['like', 'name', Yii::$app->request->getQueryParam('filtername', '')])
            ->andFilterWhere(['like', 'description', Yii::$app->request->getQueryParam('filterdescription', '')]);

        return $dataProvider;
    }

    static function allRolesAndPermissions()
    {
        $auth = Yii::$app->authManager;

        $query = (new Query())->from($auth->itemTable);

        return $query->all();
    }

    public function save()
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission($this->name);
        $permission->description = $this->description;
		try {
			return $auth->add($permission);
		} catch (IntegrityException $exception) {
			$this->addError('name', Yii::t('yii', '{attribute} "{value}" has already been taken.', ['attribute' => $this->getAttributeLabel('name'), 'value' => $this->name]));
		}
    }

    public function update($name)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        $permission->name = $this->name;
        $permission->description = $this->description;
		try {
			return $auth->update($name, $permission);
		} catch(IntegrityException $exception) {
			$this->addError('name', Yii::t('yii', '{attribute} "{value}" has already been taken.', ['attribute' => $this->getAttributeLabel('name'), 'value' => $this->name]));
		}

		return false;
    }

    static function getPermit($name)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        $model = new self;
        $model->name = $permission->name;
        $model->description = $permission->description;
        return $model;
    }

    static function delete($name)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        
        return $auth->remove($permission);
    }
}
