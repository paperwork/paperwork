<?php

/*
| ----------------------------------------------------------------------------
| Include Database Details From File
| ----------------------------------------------------------------------------
*/
if(File::exists(storage_path()."/db_settings")) {
    $wholeString = file_get_contents(storage_path()."/db_settings");
    $databaseInfo = explode(", ", $wholeString);
}else{
    $databaseInfo = array("mysql", (getenv('DB_1_PORT_3306_TCP_ADDR') ? getenv('DB_1_PORT_3306_TCP_ADDR') : '127.0.0.1'), "3306", "paperwork", "paperwork", "paperwork");
}

return array(

	/*
	|--------------------------------------------------------------------------
	| PDO Fetch Style
	|--------------------------------------------------------------------------
	|
	| By default, database results will be returned as instances of the PHP
	| stdClass object; however, you may desire to retrieve records in an
	| array format for simplicity. Here you can tweak the fetch style.
	|
	*/

	'fetch' => PDO::FETCH_CLASS,

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work. Of course
	| you may use many connections at once using the Database library.
	|
	*/

	'default' => isset($databaseInfo[0]) ? $databaseInfo[0] : 'mysql',

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => ($databaseInfo[1] !== ":memory:") ? __DIR__.'/../database/production.sqlite' : ':memory:',
			'prefix'   => '',
		),

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => isset($databaseInfo[1]) ? trim($databaseInfo[1]) : (getenv('DB_1_PORT_3306_TCP_ADDR') ? getenv('DB_1_PORT_3306_TCP_ADDR') : '127.0.0.1'),
			'port'      => isset($databaseInfo[2]) ? trim($databaseInfo[2]) : '3306',
			'database'  => isset($databaseInfo[5]) ? trim($databaseInfo[5]) : 'paperwork', //(File::exists(storage_path()."/db_settings")) ? 'paperwork' : '',
			'username'  => isset($databaseInfo[3]) ? trim($databaseInfo[3]) : 'paperwork',
			'password'  => isset($databaseInfo[4]) ? trim($databaseInfo[4]) : 'paperwork',
			'charset'   => 'utf8',
			'collation' => 'utf8_general_ci',
			'prefix'    => '',
		),

		'pgsql' => array(
			'driver'   => 'pgsql',
			'host'     => 'localhost',
			'database' => 'forge',
			'username' => 'forge',
			'password' => '',
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		),

		'sqlsrv' => array(
			'driver'   => 'sqlsrv',
			'host'     => 'localhost',
			'database' => 'database',
			'username' => 'root',
			'password' => '',
			'prefix'   => '',
		),

	),

	/*
	|--------------------------------------------------------------------------
	| Migration Repository Table
	|--------------------------------------------------------------------------
	|
	| This table keeps track of all the migrations that have already run for
	| your application. Using this information, we can determine which of
	| the migrations on disk haven't actually been run in the database.
	|
	*/

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => array(

		'cluster' => false,

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		),

	),

);
