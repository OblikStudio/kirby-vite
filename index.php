<?php

use Kirby\Cms\App;
use Oblik\KirbyVite\Vite;

load([
	'Oblik\\KirbyVite\\Vite' => 'Vite.php'
], __DIR__);

function vite()
{
	return Vite::instance();
}

App::plugin('oblik/vite', [
	'options' => [
		'server' => [
			'port' => 3000,
			'https' => false,
		],
		'build' => [
			'outDir' => 'dist'
		]
	]
]);
