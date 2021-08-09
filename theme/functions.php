<?php


$composer_autoload = dirname( __DIR__ ) . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}


if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return dirname( get_stylesheet_directory() ) . '/static/no-timber.html';
		}
	);
	return;
}

Timber::$dirname = array( '../views' );

Timber::$autoescape = false;


class StarterSite extends Timber\Site {
	public function __construct() {
		$this->__runEngine();
		#$this->__loadPageTemplates();
		parent::__construct();
	}
 
	/**
	 * Include All Engine Files.
	 */
	public function __runEngine()
	{
		$directories = ['core'];

		foreach ($directories as $dir) {
				
			$filePath 	= TEMPLATEPATH.'/'.$dir; 
			$php_files 	= scandir($filePath);
			$collectOfFiles = collect($php_files);
			$slice 			= $collectOfFiles->slice(2); 
			$collectOfFiles = $slice->all(); 

			foreach($collectOfFiles as $perFile)
			{
				include $filePath.'/'.$perFile;
			} 
		} 

		$this->__startClasses();
	}

	/**
	 * Locad page templates
	 */
	public function loadPageTemplates()
	{
		return '';
		$directories = ['page-templates'];

		foreach ($directories as $dir) {
				
			$filePath 	= TEMPLATEPATH.'/'.$dir;
			$php_files 	= scandir($filePath);
			$collectOfFiles = collect($php_files);
			$slice 			= $collectOfFiles->slice(2); 
			$collectOfFiles = $slice->all(); 

			foreach($collectOfFiles as $perFile)
			{
				include $filePath.'/'.$perFile;
			} 
		} 
	}

	/**
	 * Autoload Classes
	 */
	private function __startClasses()
	{
		new EngineContext();
		new EngineFiltersAndActions();
		new EngineACF();
		new EngineWooCommerce();
	} 


}

new StarterSite();
