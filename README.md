# WebHookManager
WebHookManager allows you to easily associate an action with a specific repository event using webhooks.

## Installation
It's highly recommended to use composer to install WebHookManagers:

```
composer require gnello/web-hook-manager
```

Read more about how to install and use Composer on your local machine [here][3].

##Configuration

### On Bitbucket
- Go to the settings of your repository
- Click on "Webhooks" under "Workflow"
- Click on "Add webhook"
- Enter the url of WebHookManagers configured on your server (es. https://mysite.com/webhooks)
- Set the triggers
- Save!

### On Github
- Go to the settings of your repository
- Click on "Webhooks" under "Options"
- Click on "Add webhook"
- Enter the url of WebHookManagers configured on your server (es. https://mysite.com/webhooks)
- Set the content type on `application/json`
- Set the events
- Save!

### On custom service
This is up to you!

## Usage
Using WebHookManager is very simple:

### Bitbucket
```php
require '../vendor/autoload.php';

use \Gnello\WebHookManager\App;

$WebHookManager = new App();

//Action on build passed
$WebHookManager->add(\Gnello\WebHookManager\Services\BitbucketService::BUILD_STATUS_CREATED, function(App $app) {
    $payload = $app->getService()->getPayload();

    if ($payload['commit_status']['state'] == 'SUCCESSFUL') {
        //do some stuff
    }
});

$WebHookManager->listen();
```

### Github
```php
require '../vendor/autoload.php';

use \Gnello\WebHookManager\App;

$WebHookManager = new App(['service' => \Gnello\WebHookManager\Services\ServiceInterface::GITHUB]);

//Action on build passed
$WebHookManager->add(\Gnello\WebHookManager\Services\GithubService::ALL, function(App $app) {
    $payload = $app->getService()->getPayload();

    //do some stuff
});

$WebHookManager->listen();
```

### Custom service
To use a custom service, you must create a class that implements the ```\Gnello\WebHookManager\Services\ServiceInterface``` interface
and then register it on WebHookManager. In WebHookManager options, you must specify that you want to use a custom service.

```php
require '../vendor/autoload.php';

use \Gnello\WebHookManager\App;

$WebHookManager = new App(['service' => \Gnello\WebHookManager\Services\ServiceInterface::CUSTOM]);
$WebHookManager->registerCustomService(CustomService::class);

//Action on custom event
$WebHookManager->add('event', function(App $app) {
    $payload = $app->getService()->getPayload();
    //do some stuff
});

$WebHookManager->add('another_event', function(App $app) {
    //do some stuff
});

$WebHookManager->listen();
```

## Options
- Bitbucket is the default service, but you can change it as follows:
```php
//github
$WebHookManager = new \Gnello\WebHookManager\App([
    'service' => \Gnello\WebHookManager\Services\ServiceInterface::GITHUB
]);

//custom service
$WebHookManager = new \Gnello\WebHookManager\App([
    'service' => \Gnello\WebHookManager\Services\ServiceInterface::CUSTOM
]);
```

- The json_decode of Bitbucket and Github services is set to convert the returned objects into associative arrays. 
You can change this behavior in this way:
```php
$WebHookManager = new \Gnello\WebHookManager\App([
    'json_decode_assoc' => false
]);
```

## Contact
- luca@gnello.com

[3]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx