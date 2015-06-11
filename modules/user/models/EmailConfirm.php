<?php

namespace app\modules\user\models;

use yii\base\InvalidParamException;
use Yii;

/**
 * Password reset form
 */
class EmailConfirm
{
    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array $config
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Email confirm token cannot be blank.');
        }
        $this->_user = User::findByEmailConfirmToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong Email confirm token.');
        }
    }

    /**
     * Confirm email.
     *
     * @return boolean if email was confirmed.
     */
    public function confirmEmail()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();

        return $user->save();
    }
}
