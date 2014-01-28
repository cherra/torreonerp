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

$active_group = 'Torreon';
$active_record = TRUE;

$db['Torreon']['hostname'] = 'localhost';
$db['Torreon']['username'] = 'cherra';
$db['Torreon']['password'] = 'cherra3003';
$db['Torreon']['database'] = 'Torreon';
$db['Torreon']['dbdriver'] = 'mysql';
$db['Torreon']['dbprefix'] = '';
$db['Torreon']['pconnect'] = TRUE;
$db['Torreon']['db_debug'] = TRUE;
$db['Torreon']['cache_on'] = FALSE;
$db['Torreon']['cachedir'] = '';
$db['Torreon']['char_set'] = 'utf8';
$db['Torreon']['dbcollat'] = 'utf8_general_ci';
$db['Torreon']['swap_pre'] = '';
$db['Torreon']['autoinit'] = TRUE;
$db['Torreon']['stricton'] = FALSE;

$db['TorreonSucursal']['hostname'] = 'localhost';
$db['TorreonSucursal']['username'] = 'cherra';
$db['TorreonSucursal']['password'] = 'cherra3003';
$db['TorreonSucursal']['database'] = 'TorreonSucursal';
$db['TorreonSucursal']['dbdriver'] = 'mysql';
$db['TorreonSucursal']['dbprefix'] = '';
$db['TorreonSucursal']['pconnect'] = TRUE;
$db['TorreonSucursal']['db_debug'] = TRUE;
$db['TorreonSucursal']['cache_on'] = FALSE;
$db['TorreonSucursal']['cachedir'] = '';
$db['TorreonSucursal']['char_set'] = 'utf8';
$db['TorreonSucursal']['dbcollat'] = 'utf8_general_ci';
$db['TorreonSucursal']['swap_pre'] = '';
$db['TorreonSucursal']['autoinit'] = TRUE;
$db['TorreonSucursal']['stricton'] = FALSE;

$db['Mayoreo']['hostname'] = 'localhost';
$db['Mayoreo']['username'] = 'cherra';
$db['Mayoreo']['password'] = 'cherra3003';
$db['Mayoreo']['database'] = 'Mayoreo';
$db['Mayoreo']['dbdriver'] = 'mysql';
$db['Mayoreo']['dbprefix'] = '';
$db['Mayoreo']['pconnect'] = TRUE;
$db['Mayoreo']['db_debug'] = TRUE;
$db['Mayoreo']['cache_on'] = FALSE;
$db['Mayoreo']['cachedir'] = '';
$db['Mayoreo']['char_set'] = 'utf8';
$db['Mayoreo']['dbcollat'] = 'utf8_general_ci';
$db['Mayoreo']['swap_pre'] = '';
$db['Mayoreo']['autoinit'] = TRUE;
$db['Mayoreo']['stricton'] = FALSE;

$db['Taqueria']['hostname'] = 'localhost';
$db['Taqueria']['username'] = 'cherra';
$db['Taqueria']['password'] = 'cherra3003';
$db['Taqueria']['database'] = 'Taqueria';
$db['Taqueria']['dbdriver'] = 'mysql';
$db['Taqueria']['dbprefix'] = '';
$db['Taqueria']['pconnect'] = TRUE;
$db['Taqueria']['db_debug'] = TRUE;
$db['Taqueria']['cache_on'] = FALSE;
$db['Taqueria']['cachedir'] = '';
$db['Taqueria']['char_set'] = 'utf8';
$db['Taqueria']['dbcollat'] = 'utf8_general_ci';
$db['Taqueria']['swap_pre'] = '';
$db['Taqueria']['autoinit'] = TRUE;
$db['Taqueria']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */