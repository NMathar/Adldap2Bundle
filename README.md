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
    
app/AppKernel:

    new Adldap2Bundle\Adldap2Bundle(),
