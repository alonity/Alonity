# Alonity
Lite and fast framework

## Install
`composer require alonity/alonity`

### Examples
```php
use alonity\alonity\Alonity;
use alonity\alonity\AlonityException;

$alonity = new Alonity();

$alonity->getRouter()->get('', ['app\\controllers\\IndexController', 'mymethod']);

// $alonity->setRootDir('set/root/directory'); // If you use custom root directory, change it
// $alonity->setTemplateDir('set/template/directory'); // If you use custom template directory, change it
// $alonity->setPublicDir('set/public/directory'); // If you use custom public directory, change it

try {
    $alonity->execute();
}catch (AlonityException $e){
    $error = $e->getMessage();
}

if(isset($error)){ exit($error); }
```