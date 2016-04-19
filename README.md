[![Stories in Ready](https://badge.waffle.io/NMonst4/Adldap2Bundle.png?label=ready&title=Ready)](https://waffle.io/NMonst4/Adldap2Bundle)
# Project in progress.....

## Installation

Insert Adldap2Bundle into your `composer.json` file:

        [...]
        "require" : {
            [...]
            "Adldap2Bundle" : "dev-master"
        },
        "repositories" : [{
            "type" : "vcs",
            "url" : "https://github.com/NMonst4/Adldap2Bundle.git"
        }],
        [...]
   
Console:

    curl -sS https://getcomposer.org/installer | php
    php composer.phar update Adldap2Bundle
    php composer.phar composer require "adldap2/adldap2"
    
app/AppKernel:

    new Adldap2Bundle\Adldap2Bundle(),
    
## Usage

        $adLdap = $this->get("adldap2user");
        var_dump($adLdap->getAllUsers());

##Configuration example
```
    adldap2:
        config:
            account_suffix: "@gatech.edu"
            domain_controllers: ["whitepages.gatech.edu"]
            port: 389
            base_dn: "dc=whitepages,dc=gatech,dc=edu"
            admin_username: ""
            admin_password: ""
            follow_referrals: true
            use_ssl: false
            use_tls: false
            use_sso: false
```
