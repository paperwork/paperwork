<?php namespace Paperwork;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\GenericUser;
use Illuminate\Hashing\HasherInterface;
use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\App;
use adLDAP\adLDAP;

class EloquentLdapAuthenticatedUserProvider extends EloquentUserProvider
{
    
    private $config;
    
    private $adLdap;
    
    public function __construct(HasherInterface $hasher, $model,  $config)
    {
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
    public function retrieveByCredentials(array $credentials)
    {
        $username = $credentials['username'];
        if ($this->adLdap->authenticate($username, $credentials['password'])){
            $user = $this->createModel()->query()->where('username',$username)->first();
            if ($user == null && $this->config['autoRegister']){
                $ldapInfo = $this->adLdap->user()->info($username,array("givenname","sn"))[0];
                $userInfo = array();
                $userInfo['firstname'] = isset($ldapInfo['givenname']) ? $ldapInfo['givenname'][0] : $username;
                $userInfo['lastname'] = isset($ldapInfo['sn']) ? $ldapInfo['sn'][0] : '';
                $userInfo['username'] = $username;
                $userInfo['password'] = 'ldapAuth';
                return App::make('UserRegistrator')->registerUser($userInfo,$this->config['registrationLanguage']);
            } elseif (isset($credentials['isRegister'])) {
                //if we're not auto registering, we need to let Guard know that we are valid authentication, so
                //we will return this dummy object here
                return new GenericUser(array("id"=>$username));
            }
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
    public function validateCredentials(UserInterface $user, array $credentials)
    {
        return $this->adLdap->authenticate($credentials['username'], $credentials['password']);
    }
} 