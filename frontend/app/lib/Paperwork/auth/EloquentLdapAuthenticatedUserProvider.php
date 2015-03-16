<?php namespace Paperwork;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Hashing\HasherInterface;
use Illuminate\Auth\UserInterface;
use adLDAP\adLDAP;

class EloquentLdapAuthenticatedUserProvider extends EloquentUserProvider{
    
    private $config;
    
    private $adLdap;
    
    public function __construct(HasherInterface $hasher, $model,  $config){
        parent::__construct($hasher,$model);
        $this->config = $config;
        $this->adLdap = new adLDAP($this->config);
    }

    /**
     * Retrieve a user by the given credentials.
     * This will first authenticate against ldap before loading the user with eloquent
     * @param  array  $credentials
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByCredentials(array $credentials){
        $username = $credentials['username'];
        if ($this->adLdap->authenticate($credentials['username'], $credentials['password'])){
            return $this->createModel()->query()->where('username',$username)->first();
        }
        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Auth\UserInterface  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserInterface $user, array $credentials){
        return $this->adLdap->authenticate($credentials['username'], $credentials['password']);
    }
} 