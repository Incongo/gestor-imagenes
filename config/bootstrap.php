<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 */

/*
 * Configure paths required to find CakePHP + general filepath constants
 */
require __DIR__ . DIRECTORY_SEPARATOR . 'paths.php';

/*
 * Bootstrap CakePHP
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorTrap;
use Cake\Error\ExceptionTrap;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Detection\MobileDetect;
use function Cake\Core\env;

/*
 * Load global functions
 */

require CAKE . 'functions.php';

/*
 * Cargar variables de entorno desde .env
 * IMPORTANTE: Este bloque debe estar activado para usar el archivo .env
 */
if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
    $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
    $dotenv->parse()
        ->putenv()
        ->toEnv()
        ->toServer();
}

/*
 * Cargar configuración principal
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Cargar configuración local (sobrescribe app.php)
 */
if (file_exists(CONFIG . 'app_local.php')) {
    Configure::load('app_local', 'default');
}

/*
 * Configuración de caché para debug mode
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+1 minute');
    Configure::write('Cache._cake_translations_.duration', '+1 minute');
}

/*
 * Configuración de zona horaria y encoding
 */
date_default_timezone_set(Configure::read('App.defaultTimezone'));
mb_internal_encoding(Configure::read('App.encoding'));
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Registro de manejadores de errores
 */
(new ErrorTrap(Configure::read('Error')))->register();
(new ExceptionTrap(Configure::read('Error')))->register();

/*
 * Configuración específica para CLI
 */
if (PHP_SAPI === 'cli') {
    if (Configure::check('Log.debug')) {
        Configure::write('Log.debug.file', 'cli-debug');
    }
    if (Configure::check('Log.error')) {
        Configure::write('Log.error.file', 'cli-error');
    }
}

/*
 * Configurar URL base completa
 */
$fullBaseUrl = Configure::read('App.fullBaseUrl');
if (!$fullBaseUrl) {
    $httpHost = env('HTTP_HOST');
    if ($httpHost) {
        $protocol = (env('HTTPS') || env('HTTP_X_FORWARDED_PROTO') === 'https') ? 'https' : 'http';
        $fullBaseUrl = $protocol . '://' . $httpHost;
    }
}
if ($fullBaseUrl) {
    Router::fullBaseUrl($fullBaseUrl);
}
unset($fullBaseUrl);

/*
 * Aplicar configuraciones a los sistemas correspondientes
 */
Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Mailer::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/*
 * Detectores para mobile y tablet
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new MobileDetect();
    return $detector->isMobile();
});

ServerRequest::addDetector('tablet', function ($request) {
    $detector = new MobileDetect();
    return $detector->isTablet();
});
