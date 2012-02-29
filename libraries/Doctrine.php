<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 *
 * This class sets Doctrine 1.2.x up for CodeIgniter 2.x 
 * It's a library
 *
 * @package     CodeIgniter
 * @author      Cees van Egmond
 * @link        www.wearejust.com
 * @since       1.0
 * @version     $Revision: 7490 $
 */
 
require_once 'Doctrine/Core.php';

class Doctrine extends Doctrine_Core
{
	public function __construct()
	{
 		require_once(realpath(dirname(__FILE__) . '/..') . DIRECTORY_SEPARATOR . 'config/database.php');
		
		$db['default']['cachedir'] = ""; 
		$db['default']['dsn'] = 
			$db['default']['dbdriver'] . 
          	'://' . $db['default']['username'] . 
            ':' . $db['default']['password']. 
            '@' . $db['default']['hostname'] . 
            '/' . $db['default']['database'];

		// Set the autoloader
		spl_autoload_register(array('Doctrine', 'autoload'));
		
		// Load the Doctrine connection
		Doctrine_Manager::connection($db['default']['dsn'], $db['default']['database']);
		
		// Load the models for the autoloader
		Doctrine::loadModels(realpath(dirname(__FILE__) . '/..') . DIRECTORY_SEPARATOR . 'models');  
		 
	}
	
	public function setUpCommandLine()
	{
		$config = array('
				 data_fixtures_path'  =>  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/fixtures',
                'models_path'         =>  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/models',
                'migrations_path'     =>  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/migrations',
                'sql_path'            =>  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/sql',
                'yaml_schema_path'    =>  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/schema');

		$cli = new Doctrine_Cli($config);
		$cli->run($_SERVER['argv']);             
	}
}

/* End of file DoctrineSetup.php */