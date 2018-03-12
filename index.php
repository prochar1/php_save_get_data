<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = isset($_POST['name']) ? $_POST['name'] : null;
	$score = isset($_POST['score']) ? $_POST['score'] : null;
	$table = isset($_POST['table']) ? $_POST['table'] : 'default';
	if(is_null($name) or is_null($score)){
		http_response_code(404);
		die();
	}
	$d = array(
		'name' => $name,
		'score' => $score
	);
	$file = __DIR__.'/data/'.$table.'.json';
	$data = file_exists($file) ? json_decode(file_get_contents($file)) : array();
	$data[] = $d;
	file_put_contents(__DIR__.'/data/'.$table.'.json',json_encode($data));
	echo 'ok';
} else {
	$table = isset($_GET['table']) ? $_GET['table'] : 'default';
	$file = __DIR__.'/data/'.$table.'.json';
	if(file_exists($file)) {
		$data = json_decode(file_get_contents($file));
		usort($data, function($a, $b){
			return strcmp($b->score, $a->score);
		});
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	} else  {
		http_response_code(404);
		die();
	}

}

