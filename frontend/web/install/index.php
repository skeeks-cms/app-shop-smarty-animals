<?php
/**
 * index
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 20.02.2015
 * @since 1.0.0
 */
//error_reporting(E_ALL | E_STRICT);
// определяем режим вывода ошибок
//ini_set('display_errors', 'On');
/**
 * Обязательная переменная
 */
define('PUBLIC_DIR', dirname(__FILE__));
define('ROOT_DIR', realpath(__DIR__ . '/../../../'));
define('INSTALL_DIR', ROOT_DIR . '/install');

include INSTALL_DIR . '/web/bootstrap.php';