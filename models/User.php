<?php namespace Plugins\RainLab\User\Models;

use October\Rain\Auth\Models\User as UserBase;

class User extends UserBase
{
    /**
     * @var string The database table used by the model.
     */
    protected $table = 'october_users';

    /**
     * Validation rules
     */
    public $rules = [
        'email' => 'required|between:3,64|email|unique:october_users',
        'password' => 'required:create|between:2,32|confirmed',
        'password_confirmation' => 'required_with:password|between:2,32'
    ];

    /**
     * Relations
     */
    // public $belongsToMany = [
    //     'groups' => ['Plugins\RainLab\User\Models\Group', 'table' => 'october_user_groups']
    // ];

    public $morphOne = [
        'avatar' => ['Modules\System\Models\File', 'name' => 'attachment']
    ];

    /**
     * Purge attributes from data set.
     */
    protected $purgeable = ['password_confirmation'];

    protected static $loginAttribute = 'email';

    /**
     * Gets a code for when the user is persisted to a cookie or session which identifies the user.
     * @return string
     */
    public function getPersistCode()
    {
        if (!$this->persist_code)
            return parent::getPersistCode();

        return $this->persist_code;
    }

    /**
     * Returns the public image file path to this user's avatar.
     */
    public function getAvatarPath()
    {
        if ($this->avatar)
            return $this->avatar->getPath();
        else
            return '//www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=25';
    }

}