<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'confirmation');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Define one to many relationship with profiles
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles()
    {
        return $this->hasMany('Profile');
    }

    /**
     * Define one to many relationship with tablets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tablets()
    {
        return $this->hasMany('Tablet');
    }
    
    /**
     * Get last inactive tablet for user
     * 
     * @param string $order
     * @return Tablet
     */
    public function getLastInactiveTablet($order = 'desc')
    {
        return $this->tablets()
                ->orderBy('created_at', $order)
                ->where('is_active', 0)
                ->firstOrFail();
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($rememberToken)
    {
        $this->remember_token = $rememberToken;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}