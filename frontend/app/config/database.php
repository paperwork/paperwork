<?php

/*
| ----------------------------------------------------------------------------
| Include Database Details From File
| ----------------------------------------------------------------------------
*/

if(File::exists(storage_path() . "/config/database.json")) {
    $configuration = json_decode(file_get_contents(storage_path() . "/config/database.json"));
}else{
    $configuration = json_decode(file_get_contents(storage_path() . "/config/default_database.json"));
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

	'default' => $configuration->driver ?: 'mysql',

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
			'database' => $configuration->database ?: ':memory:',
			'prefix'   => '',
		),

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => $configuration->host ?: (getenv('DB_1_PORT_3306_TCP_ADDR') ? getenv('DB_1_PORT_3306_TCP_ADDR') : '127.0.0.1'),
			'port'      => $configuration->port ?: '3306',
			'database'  => $configuration->database ?: 'paperwork', 
			'username'  => $configuration->username ?: 'paperwork',
			'password'  => $configuration->password ?: 'paperwork',
			'charset'   => 'utf8',
			'collation' => 'utf8_general_ci',
			'prefix'    => '',
		),

		'pgsql' => array(
			'driver'   => 'pgsql',
			'host'     => $configuration->host ?: 'localhost',
			'database' => $configuration->database ?: 'forge',
			'username' => $configuration->username ?: 'forge',
			'password' => $configuration->password ?: '',
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		),

		'sqlsrv' => array(
			'driver'   => 'sqlsrv',
			'host'     => $configuration->host ?: 'localhost',
			'database' => $configuration->database ?: 'database',
			'username' => $configuration->username ?: 'root',
			'password' => $configuration->password ?: '',
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
