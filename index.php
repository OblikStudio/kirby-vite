<?php

use Kirby\Cms\App;
use Kirby\Http\Environment;
use Oblik\KirbyVite\Vite;

load([
	'Oblik\\KirbyVite\\Vite' => 'Vite.php'
], __DIR__);

/**
 * Returns the Vite singleton class instance.
 */
if (!function_exists('vite')) {
	function vite(): Vite
	{
		return Vite::instance();
	}
}

App::plugin('oblik/vite', [
	'options' => [
		'server' => [
			'host' => (new Environment())->host(),
			'port' => 5173,
			'https' => false,
		],
		'build' => [
			'outDir' => 'dist'
		]
	]
]);
