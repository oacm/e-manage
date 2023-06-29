<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;
$db['default'] = array(
    'dsn'   => '',
    'hostname' => '150.136.40.56',
    'username' => 'root',
    'password' => 'N;nlyp?5j;cb',
    'database' => 'fenix_intranet_prd',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
/*$db['default']['hostname'] = '150.136.40.56';
$db['default']['username'] = 'root';
$db['default']['password'] = 'N;nlyp?5j;cb';
$db['default']['database'] = 'fenix_intranet_prd';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;*/

$db['energy'] = array(
    'dsn'   => '',
    'hostname' => '150.136.40.56',
    'username' => 'root',
    'password' => 'N;nlyp?5j;cb',
    'database' => 'energy_prd',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
/*$db['energy']['hostname'] = '150.136.40.56';
$db['energy']['username'] = 'root';
$db['energy']['password'] = 'N;nlyp?5j;cb';
$db['energy']['database'] = 'energy_prd';
$db['energy']['dbdriver'] = 'mysql';
$db['energy']['dbprefix'] = '';
$db['energy']['pconnect'] = TRUE;
$db['energy']['db_debug'] = TRUE;
$db['energy']['cache_on'] = FALSE;
$db['energy']['cachedir'] = '';
$db['energy']['char_set'] = 'utf8';
$db['energy']['dbcollat'] = 'utf8_general_ci';
$db['energy']['swap_pre'] = '';
$db['energy']['autoinit'] = TRUE;
$db['energy']['stricton'] = FALSE;*/

$db['weather'] = array(
    'dsn'   => '',
    'hostname' => '150.136.40.56',
    'username' => 'root',
    'password' => 'N;nlyp?5j;cb',
    'database' => 'weather_prd',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
/*$db['weather']['hostname'] = '150.136.40.56';
$db['weather']['username'] = 'root';
$db['weather']['password'] = 'N;nlyp?5j;cb';
$db['weather']['database'] = 'weather_prd';
$db['weather']['dbdriver'] = 'mysql';
$db['weather']['dbprefix'] = '';
$db['weather']['pconnect'] = TRUE;
$db['weather']['db_debug'] = TRUE;
$db['weather']['cache_on'] = FALSE;
$db['weather']['cachedir'] = '';
$db['weather']['char_set'] = 'utf8';
$db['weather']['dbcollat'] = 'utf8_general_ci';
$db['weather']['swap_pre'] = '';
$db['weather']['autoinit'] = TRUE;
$db['weather']['stricton'] = FALSE;*/


/* End of file database.php */
/* Location: ./application/config/database.php */