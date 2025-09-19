<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nexacore\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    /**
     * {@inheritdoc}
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }

    /**
     * {@inheritdoc}
     */
    public function setRememberToken($token): void
    {
        $this->remember_token = $token;
        $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    /**
     * Set the password attribute (automatically hash it).
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }
}