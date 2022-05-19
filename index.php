<?php

use Kirby\Cms\App;
use Kirby\Http\Server;
use Oblik\KirbyVite\Vite;

load([
	'Oblik\\KirbyVite\\Vite' => 'Vite.php'
], __DIR__);

/**
 * Returns the Vite singleton class instance.
 */
function vite()
{
	return Vite::instance();
}

App::plugin('oblik/vite', [
	'options' => [
		'server' => [
			'host' => Server::host(),
			'port' => 3000,
			'https' => false,
		],
		'build' => [
			'outDir' => 'dist'
		]
	]
]);
