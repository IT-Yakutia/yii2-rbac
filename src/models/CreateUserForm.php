<?php

namespace ityakutia\rbac\models;

use common\models\User;

class CreateUserForm extends \yii\base\Model
{
	public $username;
	public $email;
	public $password;

	/**
	 * @inheritdoc
	 */
	public function rules(): array
	{
		return [
			[['username', 'email', 'password'], 'required'],
			[['username', 'password'], 'string'],
			['password', 'string', 'min' => 6],
			['email', 'email'],
			[['username', 'email', 'password'], 'trim', 'skipOnError' => true, 'skipOnEmpty' => true],
			[['username', 'email'], 'unique', 'targetClass' => User::class],
		];
	}

	/**
	 * @return bool
	 */
	public function createUser(): bool
	{
		if (!$this->validate()) {
			return false;
		}

		$user = new User(
			$this->getAttributes()
			+ ['status' => User::STATUS_ACTIVE]
		);
		$user->generateAuthKey();

		return $user->save();
	}
}
