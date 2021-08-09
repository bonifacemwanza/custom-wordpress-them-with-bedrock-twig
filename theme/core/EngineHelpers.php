<?php 

    /**
     * Helpers
     * @version 1.0
     * @author Fatih Toprak
     */


    function trimText($str, $start, $end)
    {
        return mb_substr(strip_tags($str), $start, $end);
    }

    function getReadingTime($postId)
    {
        return get_post_meta($postId, '_yoast_wpseo_estimated-reading-time-minutes', true);   
    }

    function getPermalink($postId)
    {
        return get_the_permalink($postId);   
    }

    function formatPhone($str)
    {
        return str_replace([' ', '-'],'',strip_tags($str));
    }

    function fetchImageItem($imageId)
    {
        $data = @formatproduct($imageId);
        return data_get($data, 'product_image', null);
    }

    function js_str($s)
    {
        return '"' . addcslashes($s, "\0..\37\"\\") . '"';
    }

    function js_array($array)
    {
        $temp = array_map('js_str', $array);
        return '[' . implode(',', $temp) . ']';
    }

    function js_array_html($array) {
        $out = '<script>';
        $out .= 'var products_in_cart = '. js_array($array). ';';
        $out .= '</script>';
        return $out;
    }

    function isInCart( $product_id )
    {  
        global $woocommerce;
 
        $data = collect(WC()->cart->get_cart_contents());
        $subset = $data->map(function ($perItemIds) {
            return collect($perItemIds)
                ->only(['product_id', 'variation_id'])
                ->all();
        });

        $productIds = array_flatten($subset);
        return in_array($product_id,$productIds); 
  
    }

    function dum_ray($data)
    {
        return ray($data);
    }

    function timber_set_product( $post ) 
    {
        global $product;

        if ( is_woocommerce() ) {
            $product = wc_get_product( $post->ID );
        }
    }

    function getProductPriceById($postId)
    {
        $product = wc_get_product( $postId );
        return $product->get_price();

    }