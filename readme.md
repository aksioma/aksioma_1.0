## CI with Eloqent ORM

### guide
#### 1. edit composer.json
```json
{
  "require": {
    "php": ">=5.4.0",
    "illuminate/database": "*"
  },
}
```
```shell
$ composer install
```
#### 2. edit appliction/config/config.php
```php
$config['composer_autoload'] = APPPATH.'../vendor/autoload.php';
```
#### 3. add file appliction/helper/eloquent_helper.php
```php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Capsule\Manager as Capsule;

// require the ci database config
require_once APPPATH.'config/database.php';

//  Eloquent ORM
$capsule = new Capsule;

$capsule->addConnection(
    array(
        'driver'    => 'mysql',
        'host'      => $db['default']['hostname'],
        'database'  => $db['default']['database'],
        'username'  => $db['default']['username'],
        'password'  => $db['default']['password'],
        'charset'   => $db['default']['char_set'],
        'collation' => $db['default']['dbcollat'],
        'prefix'    => $db['default']['dbprefix']
    )
);
//boot Eloquent
$capsule->bootEloquent();
```
#### 4.edit appliction/config/autoload.php
```php
$autoload['helper'] = array('eloquent');
```

### now you can use the Eloquent in ci framework