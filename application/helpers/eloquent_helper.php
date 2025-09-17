<?php

/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2016/1/15
 * Time: 9:14
 */
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Capsule\Manager as Capsule;

// require the ci database config
require_once APPPATH.'config/database.php';

//  Eloquent ORM
$capsule = new Capsule;

// foreach($config['connection'] as $nm => $val){
// 	$capsule->addConnection($val,$nm);
// }
// $capsule->addConnection(
//     array(
//         'driver' => 'sqlsrv',
//         'host' => '192.168.111.77', // Provide IP address here
//         'database' => 'stpakan',
//         'username' => 'sa',
//         'password' => 'boohoo',
//         'prefix' => '',
//     )
// );
//boot Eloquent
$capsule->bootEloquent();
