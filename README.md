# Qiscus Whatsapp API Third Party PHP Package

[![release](https://img.shields.io/github/v/release/ryuamy/whatsapp-qiscus-php?color=orange&include_prereleases)](https://packagist.org/packages/ryuamy/whatsapp-qiscus-php)

Qiscus Whatsapp API Third Party PHP Package. 

Before you use the package, make sure you have a Qiscus Multichannel account by register in [here](https://www.qiscus.com/multichannel/register). You also need WABA (WhatsApp Business Account) ID to create template.



## Instalation
Install package with composer by following command:
```
composer require ryuamy/whatsapp-qiscus-php
```


## Call Package
Add following code on your project:
```php
use Ryuamy\WAQiscus;
```


## Usages
```php
WAQiscus\Class::function( $appId, ... );
```


## Example

### Authentication

#### Get Token
```php
$bodyParameters = [
    'email' => '(Qiscus login email)',
    'password' => '(Qiscus login password)',
];

$Whatsapp = WAQiscus\Authentication::getToken( '(Application ID)', $bodyParameters );
```

### Sending Message

#### Template Message
Sending whatsapp chat with template. Make sure you have the template already on your Qiscus dashboard.
```php
$bodyParameters = [
    'to' => '62812345678',
    'type' => 'template',
    'template' => [
        'namespace' => '(namespace template)',
        'name' => 'template_testing',
        'language' => [
            'policy' => 'deterministic',
            'code' => 'en'
        ],
        'components' => array() //header, body, and footer template variables
    ]
];

$Whatsapp = WAQiscus\Message::template( '(Application ID)', '(Token Auth)', '(Channel ID)', $bodyParameters );
```
