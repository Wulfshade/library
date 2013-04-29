<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
error_reporting( E_ALL | E_STRICT | E_NOTICE );
ini_set( 'display_errors', 1 );

/**
 * The paths are controlled by app/code/local/Elite/phpunit.xml.dist
 * using the <php><env /></php> section. To make changes, make a copy
 * of phpunit.xml.dist to phpunit.xml
 */

define( 'MAGE_PATH', realpath(getenv('PHP_MAGE_PATH')));
define( 'TEMP_PATH', getenv('PHP_TEMP_PATH') );

# database details for test server
define( 'VAF_DB_USERNAME', getenv('PHP_VAF_DB_USERNAME') );
define( 'VAF_DB_PASSWORD', getenv('PHP_VAF_DB_PASSWORD') );
define( 'VAF_DB_NAME', getenv('PHP_VAF_DB_NAME') );
define( 'ELITE_CONFIG_DEFAULT', getenv('ELITE_CONFIG_DEFAULT') );
define( 'ELITE_CONFIG', getenv('ELITE_CONFIG') );
define( 'ELITE_PATH', getenv('ELITE_PATH') );

# used to make "test only code" run (Google "test code in production")
define( 'ELITE_TESTING', 1 );

set_include_path(
        PATH_SEPARATOR . MAGE_PATH . '/lib/Vehicle-Fits-Core/library/'
        . PATH_SEPARATOR . MAGE_PATH . '/lib/Vehicle-Fits-Core/vendor/zendframework/zendframework1/library/'
        . PATH_SEPARATOR . get_include_path()
);

$_SESSION = array();

function my_autoload($class_name) {
    $file = str_replace( '_', '/', $class_name . '.php' );

    if( 'Mage.php' == $file )
    {
        throw new Exception();
    }
    require_once $file;
}
spl_autoload_register('my_autoload');

class Mage
{
    static function resetRegistry() {}
}