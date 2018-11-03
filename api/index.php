<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

include 'Router.php';
include 'Database.php';
include 'Sindyk.php';

$router = new Router();
$router->DB = new Database([
	'host'		=> 'localhost',
	'driver'	=> 'mysql',
	'database'	=> 'onawiiyo_sindyk',
	'username'	=> 'onawiiyo_sindyk',
	'password'	=> 'onawiiyo_sindyk',
	'charset'	=> 'utf8',
	'collation'	=> 'utf8_general_ci',
	'prefix'	 => ''
]);

$router->url = 'http://sindyk.com/planes/';

$router->on('GET|POST /parse', function(){
  
  $sindyk = new Sindyk($this->url);
  
  $this->DB->table('menu')->delete();
  foreach ($sindyk->getMenu() as $menu) {
    $this->DB->table('menu')->insert($menu);
  }
  
  $this->DB->table('plans')->delete();
  foreach ($sindyk->getPlans() as $menu) {
    $this->DB->table('plans')->insert($menu);
  }
  
  $this->DB->table('info')->where('url', $this->url)->delete();
  $this->DB->table('info')->insert($sindyk->getInfo());
  
  $this->response($sindyk->getAll(false), true);
  // echo 'done';
});

// Render Menu
$router->buildMenu = function ($elements, $parentId = 0) {
	$branch = [];

  foreach ($elements as $element) 
	{
    if ($element['parent'] == $parentId) 
		{
      $children = $this->buildMenu($elements, $element['id']);
			if ($children) 
			{
        $element['children'] = $children;
      }
			$branch[] = $element;
    }
  }

  return $branch;
};

$router->on('GET /menu', function(){
  $this->response($this->buildMenu($this->DB->table('menu')->getAll('array')),  true);
});

$router->on('GET /plans', function(){
  $this->response($this->DB->table('plans')->getAll('array'), true);
});

$router->on('GET /info', function(){
  $this->response($this->DB->table('info')->where('url', $this->url)->get('array'), true);
});

$router->on('GET /render', function(){
  $structure = [
    'menu' => $this->buildMenu($this->DB->table('menu')->getAll('array')),
    'information' => $this->DB->table('info')->where('url', $this->url)->get('array')
  ];

  $structure['information']['plans'] = $this->DB->table('plans')->getAll('array');

  $this->response($structure, true);
});


