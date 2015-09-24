Zendesk - ZF2 module wrapper for Zendesk PHP SDK
=====================================================

[![Build Status](https://travis-ci.org/mtymek/Zendesk.png?branch=master)](https://travis-ci.org/mtymek/Zendesk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mtymek/Zendesk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mtymek/Zendesk/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mtymek/Zendesk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mtymek/Zendesk/?branch=master)

Introduction
------------

This module allows easy access of Zendesk API from within Zend Framework 2 application.

## Available Command

### Diagnostic

```
$ php public/index.php diag
```

### Helper Command

#### List all tickets

```
$ php public/index.php eoko zendesk ticket list
```

#### Create Ticket

```
$ php public/index.php eoko zendesk ticket create
```


Installation
------------
Installation is supported via Composer:

1. Add `"mtymek/mt-zendesk-api":"dev-master"` to your `composer.json` file and run `php composer.phar update`.
2. Add `Zendesk` to your `config/application.config.php` file under the modules key.


Configuration
-------------

1. Copy `config/zendesk.local.php.dist` file into your main application's `config/autoload' directory,
rename it to `zendesk.local.php`
2. Replace placeholder values with subdomain, username and API token read from Zendesk settings page

Example:

```php
return [
    'zendesk' => [
        'subdomain' => 'mycompany',
        'username'  => 'support@mycompany.com',
        'token'     => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX',
    ],
];
```

Usage
-----

Once configured, Zendesk will expose Zendesk API client using ServiceManager. Example usage (from controller):

```php
$client = $this->getServiceLocator()->get('Zendesk\API\Client');
$newTicket = $client->tickets()->create(
    [
        'subject'   => 'Question to Support Team',
        'tags'      => ['tag1', 'tag2'],
        'requester' => [
            'email' => 'johndoe@domain.com',
        ],
        'comment'   => [
            'body' => "Ticket body"
        ],
        'priority'  => 'normal'
    ]
);
```