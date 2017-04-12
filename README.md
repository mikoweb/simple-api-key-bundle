# Simple Api Key Bundle

## Installation

Requires composer, install as follows:

    composer require mikoweb/simple-api-key-bundle

### Enable Bundle

Place in your AppKernel.php to enable the bundle:

```php
// app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Uecode\Bundle\ApiKeyBundle\UecodeApiKeyBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Mikoweb\Bundle\SimpleApiKeyBundle\MikowebSimpleApiKeyBundle(),
        );

        // ...
    }
}
```

### Configuration

Import following files in config.yml:

```yml
imports:
    # ...
    - { resource: api_groups.yml }
    - { resource: api_keys.yml }
```

Example groups file:

```yml
mikoweb_simple_api_key:
    groups:
        api_user:
            roles:
                - ROLE_API_USER
                - ROLE_DO_SOMETHING
                - ROLE_ACCESS_TO_ARTICLES
        api_extended_user:
            roles:
                - ROLE_API_USER
                - ROLE_DO_SOMETHING
                - ROLE_ACCESS_TO_ARTICLES
                - ROLE_EXTENDED_ACCESS
```

Example keys file:

```yml
mikoweb_simple_api_key:
    keys:
        normal_key: api_user
        extended_key: api_extended_user
        krwntfibN8: api_user
```

Add following entries to config.yml

```yml
# FOSUserBundle
fos_user:
    db_driver:      orm
    firewall_name:  api
    user_class:     Mikoweb\Bundle\SimpleApiKeyBundle\Entity\User

# UecodeApiKeyBundle
uecode_api_key:
    delivery: header
    parameter_name: X-Api-Key

# SimpleApiKeyBundle
mikoweb_simple_api_key:
    user_class: Mikoweb\Bundle\SimpleApiKeyBundle\Entity\User
```

#### Security firewall

`security.yml`

```yml
security:
    role_hierarchy:
        ROLE_API_USER: ROLE_USER

    providers:
        api_key:
            id: mikoweb.simple_api_key.api_key_user_provider

    firewalls:
        api:
            pattern:    ^/api/*
            api_key:    true
            stateless:  true
            provider:   api_key

    access_control:
        - { path: ^/api/, role: ROLE_API_USER }
```
