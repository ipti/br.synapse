<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//@AWESOM testando essse novo
/** 
 * TODO teste de o que precisa ser feito.
 * @todo  pode ser feito depois isso.
 */
//@todo pode ser feito depois
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/app/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//Url Definition

//define('RENDER_ONLINE', 'http://local.render.synapse.ipti.org.br/index.html');

define('RENDER_ONLINE', 'http://render.synapse.seed.ipti.org.br/index.html');


require_once($yii);

Yii::createWebApplication($config)->run();
