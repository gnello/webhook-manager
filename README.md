# WebhookManager
[![Latest Stable Version][6]][7] [![Scrutinizer Code Quality][5]][6]  
  
  
![Bitbucket][1]  ![Github][2]  
  
  
  
WebhookManager allows you to easily associate an action with a specific repository event using webhooks.  
Webhooks supported: Bitbucket, Github, Custom

## Installation
It's highly recommended to use composer to install WebhookManagers:

```
composer require gnello/webhook-manager
```

Read more about how to install and use Composer on your local machine [here][3].

##Configuration

### On Bitbucket
- Go to the settings of your repository
- Click on "Webhooks" under "Workflow"
- Click on "Add webhook"
- Enter the url of WebhookManagers configured on your server (es. https://mysite.com/webhooks)
- Set the triggers
- Save!

### On Github
- Go to the settings of your repository
- Click on "Webhooks" under "Options"
- Click on "Add webhook"
- Enter the url of WebhookManagers configured on your server (es. https://mysite.com/webhooks)
- Set the content type on `application/json`
- Set the events
- Save!

### On custom service
This is up to you!

## Usage
Using WebhookManager is very simple:

### Bitbucket
```php
require '../vendor/autoload.php';

use \Gnello\WebhookManager\App;
use \Gnello\WebhookManager\Services\BitbucketService;

$webhookManager = new App();

//Action on build passed
$webhookManager->add(BitbucketService::BUILD_STATUS_CREATED, function(BitbucketService $service) {
    $payload = $service->getPayload();

    if ($payload['commit_status']['state'] == 'SUCCESSFUL') {
        //do some stuff
    }
});

$webhookManager->listen();
```

### Github
```php
require '../vendor/autoload.php';

use \Gnello\WebhookManager\App;
use \Gnello\WebhookManager\Services\GithubService;

$webhookManager = new App(['service' => \Gnello\WebhookManager\Services\ServiceInterface::GITHUB]);

//Action on build passed
$webhookManager->add(GithubService::ALL, function(GithubService $service) {
    $payload = $service->getPayload();

    //do some stuff
});

$webhookManager->listen();
```

### Custom service
To use a custom service, you must create a class that implements the ```\Gnello\WebhookManager\Services\ServiceInterface``` interface
and then register it on WebhookManager. In WebhookManager options, you must specify that you want to use a custom service.

```php
require '../vendor/autoload.php';

use \Gnello\WebhookManager\App;
use \Gnello\WebhookManager\Services\CustomService;

$webhookManager = new App(['service' => \Gnello\WebhookManager\Services\ServiceInterface::CUSTOM]);
$webhookManager->registerCustomService(CustomService::class);

//Action on custom event
$webhookManager->add('event', function(CustomService $service) {
    $payload = $service->getPayload();
    //do some stuff
});

$webhookManager->add('another_event', function(CustomService $service) {
    //do some stuff
});

$webhookManager->listen();
```

## Options
- Bitbucket is the default service, but you can change it as follows:
```php
//github
$webhookManager = new \Gnello\WebhookManager\App([
    'service' => \Gnello\WebhookManager\Services\ServiceInterface::GITHUB
]);

//custom service
$webhookManager = new \Gnello\WebhookManager\App([
    'service' => \Gnello\WebhookManager\Services\ServiceInterface::CUSTOM
]);
```

- The json_decode of Bitbucket and Github services is set to convert the returned objects into associative arrays. 
You can change this behavior in this way:
```php
$webhookManager = new \Gnello\WebhookManager\App([
    'json_decode_assoc' => false
]);
```

## Contact
- luca@gnello.com

[1]: logos/Bitbucket@2x-blue.png
[2]: logos/GitHub_Logo.png
[3]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
[4]: https://scrutinizer-ci.com/g/gnello/webhook-manager/badges/quality-score.png?b=master
[5]: https://scrutinizer-ci.com/g/gnello/webhook-manager/?branch=master
[6]: https://poser.pugx.org/gnello/webhook-manager/v/stable
[7]: https://packagist.org/packages/gnello/webhook-manager
