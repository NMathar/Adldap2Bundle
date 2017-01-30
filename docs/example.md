# Examples

## Create user

```php
    <?php 
    $adUser = $this->get("adldap2user");
    
    $attr = array(
                'cn' => 'Username',
                'dn' => "cn=Username," . $this->config['base_dn'],
                'sn' => 'Symfony',
                'mail' => 'test@mail.com');
    
    var_dump($adUser->createUser($attr, 'SuperSecPW1234__!'));
    ?>
```

## Delete user

```php
    <?php 
    $adUser = $this->get("adldap2user");
    if ($adUser->deleteUser('Username')) {
            var_dump("User was successful deleted");
    }
    ?>
```

## Get all user informations

```php
    <?php
    $adUser = $this->get("adldap2user");
    #################### get all users with vlaues ###############################
    
    foreach ($adUser->getAllUsers() as $user) {
                var_dump($user->dn);
                var_dump($user->samaccountname);
                var_dump($user->givenname);
     }
    ?>
```



## Get user object to handle

```php
    <?php
    $adUser = $this->get("adldap2user");
     $userObj = $adUser->findUserbyUsername($username, array('dn', 'memberof', 'samaccountname', 'manager'));
    ?>
```


## Work with user object

### Change user manager

```php
    <?php
    $adUser = $this->get("adldap2user");
            ########### example for change manager ############
            $user = $adUser->findUserbyUsername("John");
            $newManager = $adLdap->findUserbyUsername("Jeff", array('dn'));
            $user->manager = $newManager->dn;
            $user->save();
    ?>
```


### Move user to OU
```php
    <?php
    $adUser = $this->get("adldap2user");
    $user = $adUser->findUserbyUsername($username);
    if ($user) {
             ########### example for change the ou #################
             //TODO: works but need a better progress
             //dn manipulation to get new dn
             $dn = $user->getDnBuilder();
 
             //name of the new ou
             $dn->addOu('TestOUone');
 
             //path to remove from the old dn
             $dn->removeOU('TestOUtwo');
 
             //remove cn because its not necessary
             $dn->removeCN($user->cn[0]);
 
             if ($user->move('cn=' . $user->cn[0], $dn->get())) {
                 var_dump('User has moved successful');
             } else {
                 var_dump('Not moved!?');
             }
 
    } else {
             var_dump('User not exist');
    }           
    ?>
```


### For additional manipulation
[Adldap2 Docs](https://github.com/Adldap2/Adldap2/tree/master/docs)


## Update user attributes

```php
    <?php
    $adUser = $this->get("adldap2user");
     //update user value
    var_dump($adUser->updateUser('John', array('mail' => 'Test@test.com')));
    ?>
```

## Delete user attributes

```php
    <?php
    $adUser = $this->get("adldap2user");
    var_dump($adUser->updateUser('John', array('mail' => null)));
    ?>
```