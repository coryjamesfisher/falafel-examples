<?php

namespace app;

use \Falafel\Column\ColumnBase;
use \Falafel\Criteria\CriteriaBase;
use \Falafel\DataSource\DataSourceArray;
use \Falafel\HTTP\RequestBase;
use \Falafel\HTTP\ResponseBase;
use \Falafel\Listing\ListingBase;
use \Falafel\Renderer\RendererCLI;
use \Falafel\Renderer\ColumnRendererCLI;

require(__DIR__ . '/../vendor/autoload.php');

class CLICol extends ColumnBase
{
   function __construct($key)
   {

	parent::__construct($key);
	$this->setRenderer(new ColumnRendererCLI());
   }

}


$criteria = new CriteriaBase();
$criteria->gt('id', 0);
$criteria->setLimit(3);

$request = new RequestBase($criteria);
$response = new ResponseBase();
$dataSource = new DataSourceArray(
	array(
		array('id' => 1, 'username' => 'coryjamesfisher', 'first_name' => 'Cory'  , 'last_name' => 'Fisher'),
		array('id' => 2, 'username' => 'karathenurse'   , 'first_name' => 'Kara'  , 'last_name' => 'Fisher'),
		array('id' => 3, 'username' => 'llizano'        , 'first_name' => 'Lucila', 'last_name' => 'Lizano')
	)
);

$renderer = new RendererCLI();

$listing = new ListingBase();
$listing->setDataSource($dataSource);
$listing->setRenderer($renderer);
$listing->addColumnDef('id', new CLICol('id'));
$listing->addColumnDef('username', new CLICol('username'));
$listing->addColumnDef('first_name', new CLICol('first_name'));
$listing->addColumnDef('last_name', new CLICol('last_name'));
$listing->exec($request, $response);

$response->send();


