<?php

    /**
     * Woocommerce Hooks And Actions
     * @version 1.0
     * @author Fatih Toprak
     */

    class EngineWooCommerce extends Timber\Site
    {

        public function __construct()
        {
            parent::__construct(); 
            add_action( 'woocommerce_before_main_content', [$this, 'beforeShopLoop'], 10, 2 ); 
            add_filter( 'woocommerce_breadcrumb_defaults', [$this, 'customWooCommerceBreadcrumb'] );
        }  

        public function beforeShopLoop()
        {
            // Before Shop loop same like WooCommerce Breadcrumb
            echo '</div>';
        } 

        public function customWooCommerceBreadcrumb()
        {
            return array(
                'delimiter'   => '<svg style="width:16px" class="mx-3" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve"><g><g><path d="M131.5,499.1c-3.1,0-6.1-1.2-8.5-3.5c-4.7-4.7-4.7-12.3,0-17L351.6,250L123,21.4c-4.7-4.7-4.7-12.3,0-17c4.7-4.7,12.3-4.7,17,0L377,241.5c2.2,2.3,3.5,5.3,3.5,8.5s-1.3,6.2-3.5,8.5L140,495.6C137.6,497.9,134.5,499.1,131.5,499.1z"/></g></g></svg>',
                'wrap_before' => '<div class="col d-none d-sm-block"><nav aria-label="breadcrumb"><ol class="breadcrumb">',
                'wrap_after'  => '</ol></nav></div>',
                'before'      => '',
                'after'       => '',
                'home'        => _x( 'Ana Sayfa', 'breadcrumb', 'woocommerce' ),
            );
        }

        
 

    }