<?php 

    /**
     * Theme Filters And Actions 
     * @version 1.0
     * @author Fatih Toprak
     */

	use Timber\Site; 
	
	class EngineFiltersAndActions extends Timber\Site {

		public function __construct() {
            parent::__construct();
			add_action( 'after_setup_theme', [$this, 'timberSupports'] );
			add_action( 'after_setup_theme', [$this, 'registerMenus'],0 );
		}  


        public function timberSupports() 
        {
            add_theme_support( 'automatic-feed-links' );
            add_theme_support( 'title-tag' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support(
                'html5',
                array(
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
                )
            );
            add_theme_support(
                'post-formats',
                array(
                    'aside',
                    'image',
                    'video',
                    'quote',
                    'link',
                    'gallery',
                    'audio',
                )
            );
            add_theme_support( 'menus' );
            add_theme_support( 'woocommerce' );
        }        

        public function registerMenus()
        {
            return register_nav_menus(
                [
                    'primary_menu' => 'Ana Menü',
                    'footer_menu'  => 'Footer Menü',
                ]
            );
        }

	} 
    