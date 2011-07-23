<?php
$cfg = array(
	#-----------------------------------------------------
	# L2JZ Configuration
	#-----------------------------------------------------
	'l2jzHomeDir'     => $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'],
	'cache'           => TRUE,
	'GZip'            => TRUE,
	'baseLanguage'    => 'english',                       //No need to change it!
	/**
	 * default - L2J Server
	 * l2j_ft  - L2J Fortress Server
	 */
	'workMode'        => 'default',
	'workModes'       => array(
		              	'default' => 'default',
		              	'l2j_ft'  => 'l2j_ft',
	                  ),
	
	#-----------------------------------------------------
	# MySQL Columns Access Configuration
	#-----------------------------------------------------
	/**
	 * You may set access levels for some data.
	 */
	'columnAccess' => array(
		'cLevel'   => 0,                                  //Showing chars levels
		'cAccount' => 10,                                 //Showing chars accounts
		'cAdena'   => 10,                                 //Showing adena count in top 100 adena page
		'iOwners'  => 0,                                  //Showing count of items in game world
	),
	
	#-----------------------------------------------------
	# Login server Configuration
	#-----------------------------------------------------
	'LS' => array(
		array(
			'ip'             => '127.0.0.1',              //Server IP.
			'port'           => '1902',                   //Server login port.
			'mysql_address'  => '192.168.0.100',              //Sql server address.
			'mysql_login'    => 'root',                   //Sql login username.
			'mysql_password' => '',                       //Sql login password.
			'mysql_database' => 'srv',                //Sql database name.
			'LnameTemplate'  => '[A-Za-z0-9]{2,}',        // This is login name template.
			'CnameTemplate'  => '[A-Za-z0-9]{2,}',        // This is char nametemplate.
		),
	),
	#-----------------------------------------------------
	# Game server(s) Configuration
	#-----------------------------------------------------
	'GS' => array(
		#server begin
		array(
			//private info
			'ip'             => '89.108.87.120',              //Server IP.
			'port'           => '7777',                   //Server game port.
			'telnetport'     => '1903',                  //Server telnet port. Don't forget to turn on telnet!
			'telnetpass'     => 'la2kkk',               //Server telnet pass. Do not forget to uncomment the string with it in telnet.propereties.
			'mysql_address'  => '192.168.0.100',              //Sql server address.
			'mysql_login'    => 'root',                   //Sql login username.
			'mysql_password' => '',                       //Sql login password.
			'mysql_database' => 'srv',                //Sql database name.
			//public info
			'info' => array(
				'name'          => 'TEST Server',          //Server name. It will be shown in client(in many places). You may write here whatever you want.
				'rateXp'        => 20,                     //Exp rate.
				'rateSp'        => 20,                     //Sp rate.
				'rateDropAdena' => 30,                     //Adena rate.
				'rateDropItems' => 45,                     //Drop rate.
				'rateDropSpoil' => 50,                     //Spoil rate.
			),
		),
		#server end
		/*
		#server begin
		array(
			//private info
			'ip'             => '89.108.87.121',              //Server IP.
			'port'           => '7777',                   //Server game port.
			'telnetport'     => '1904',                  //Server telnet port. Don't forget to turn on telnet!
			'telnetpass'     => 'la2kkk',               //Server telnet pass. Do not forget to uncomment the string with it in telnet.propereties.
			'mysql_address'  => 'localhost',              //Sql server address.
			'mysql_login'    => 'la2',                   //Sql login username.
			'mysql_password' => 'la2kkk',                       //Sql login password.
			'mysql_database' => 'l2jtestdb',                //Sql database name.
			//public info
			'info' => array(
				'name'          => 'LBR Test Server',         //Server name. It will be shown in client(in many places). You may write here whatever you want.
				'rateXp'        => 600,                     //Exp rate.
				'rateSp'        => 600,                     //Sp rate.
				'rateDropAdena' => 700,                     //Adena rate.
				'rateDropItems' => 800,                     //Drop rate.
				'rateDropSpoil' => 900,                     //Spoil rate.
			),
		), */
		#server end
	),
);
