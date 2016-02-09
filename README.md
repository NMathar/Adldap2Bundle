[![Stories in Ready](https://badge.waffle.io/NMonst4/Adldap2Bundle.png?label=ready&title=Ready)](https://waffle.io/NMonst4/Adldap2Bundle)
#Project in progress.....

## Installation

Insert Adldap2Bundle into your `composer.json` file:

        [...]
        "require" : {
            [...]
            "company/demobundle" : "dev-master"
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
    
usage

    $adLdap = $this->get("adldap2");
    $adLdap->name("TEST");
