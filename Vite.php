<?php

namespace Oblik\KirbyVite;

use Kirby\Data\Data;
use Kirby\Http\Uri;

class Vite
{
	protected static $instance;

	public static function instance()
	{
		return static::$instance ?? (static::$instance = new static());
	}

	public $manifest;

	public function __construct()
	{
		$path = implode(DIRECTORY_SEPARATOR, array_filter([
			kirby()->root(),
			option('oblik.vite.build.outDir'),
			'manifest.json'
		], 'strlen'));

		try {
			$this->manifest = Data::read($path);
		} catch (\Throwable $t) {
			// Vite is running in development mode.
		}
	}

	public function isDev(): bool
	{
		return !is_array($this->manifest);
	}

	public function prodUrl(string $path): string
	{
		return implode('/', array_filter([
			kirby()->url(),
			option('oblik.vite.build.outDir'),
			$path
		], 'strlen'));
	}

	public function devUrl(string $path): string
	{
		$uri = new Uri([
			'scheme' => option('oblik.vite.server.https') ? 'https' : 'http',
			'host'   => option('oblik.vite.server.host'),
			'port'   => option('oblik.vite.server.port'),
			'path'   => $path
		]);

		return $uri->toString();
	}

	/**
	 * Output a `<script>` tag for an entry point.
	 * @param string $entry e.g. `src/index.js`.
	 */
	public function js(string $entry): string
	{
		if (is_array($this->manifest)) {
			$url = $this->prodUrl($this->manifest[$entry]['file']);
		} else {
			$url = $this->devUrl($entry);
		}

		return js($url, ['type' => 'module']);
	}

	/**
	 * Outputs `<link>` tags for each CSS file of an entry point.
	 * @param string $entry The JavaScript entry point that includes your CSS.
	 */
	public function css(string $entry): string
	{
		if (is_array($this->manifest)) {
			foreach ($this->manifest[$entry]['css'] as $file) {
				return css($this->prodUrl($file));
			}
		}
	}
}
