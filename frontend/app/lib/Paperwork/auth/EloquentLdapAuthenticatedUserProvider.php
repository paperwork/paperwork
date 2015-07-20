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
        $user = $this->createModel()->query()->where('username',$username)->first();
        if ($user == null && ($this->config['autoRegister'] || isset($credentials['isRegister']) )){
            //if our user wasn't found, and we have auto register enabled or we're coming from the user registration
            //directly, then we'll attempt an authentication and take the appropriate action.
            $ldap_info = $this->adLdap->user()->info($username);
            if($ldap_info['count'] != 1)
                return null;

            if ($this->adLdap->authenticate($ldap_info[0]['dn'], $credentials['password'])){
                if ($this->config['autoRegister']){
                    //if we have auto register enabled, create a user and such using the ldap info.
                    $ldapInfo = $this->adLdap->user()->info($username,array("givenname","sn"))[0];
                    $userInfo = array();
                    $userInfo['firstname'] = isset($ldapInfo['givenname']) ? $ldapInfo['givenname'][0] : $username;
                    $userInfo['lastname'] = isset($ldapInfo['sn']) ? $ldapInfo['sn'][0] : '';
                    $userInfo['username'] = $username;
                    $userInfo['password'] = 'ldapAuth';
                    $user = App::make('UserRegistrator')->registerUser($userInfo,$this->config['registrationLanguage']);
                } elseif (isset($credentials['isRegister'])) {
                    //if we're not auto registering, but this is the registration process,
                    //we need to return a valid UserInterface object so that Guard will
                    //pass the authentication and actually continue with the registration process.
                    //This is necessary because we don't allow users that can't authenticate to ldap to register
                    $user = new GenericUser(array("id"=>$username));
                }
            }
        }
        return $user;
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
        $ldap_info = $this->adLdap->user()->info($credentials['username']);
        if($ldap_info['count'] != 1)
            return false;
        return $this->adLdap->authenticate($ldap_info[0]['dn'], $credentials['password']);
    }
} 