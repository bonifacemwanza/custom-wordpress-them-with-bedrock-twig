<?php 

    /**
     * ACF Options 
     * @version 1.0
     * @author Fatih Toprak
     */

    class EngineACF extends Timber\Site
    {

        private $blocks =
        [ 
            [
                'name' => 'homepage-video',
                'title' => 'Optimist :: Homepage Video'
            ],
            [
                'name' => 'grid-banners',
                'title' => 'Optimist :: Grid Banners'
            ],
            [
                'name' => 'recent-prodcuts',
                'title' => 'Optimist :: Recent Products'
            ],
            [
                'name' => 'big-banners',
                'title' => 'Optimist :: Big Banners'
            ],
            [
                'name' => 'info-container',
                'title' => 'Optimist :: Information Container'
            ],
            [
                'name' => 'recent-posts',
                'title' => 'Optimist :: Recent Posts'
            ],
            [
                'name' => 'instagram-feed',
                'title' => 'Optimist :: Instagram Feed'
            ],

        ];

        public function __construct()
        {
            parent::__construct();
            add_action('admin_head', [$this, 'adminStyle']);
            add_action('acf/init', [$this, 'acfBlocks']);
            add_action('acf/init', [$this, 'acfOptions']); 
        }

        /**
         * Define Gutenberg Blocks
         * @version 1.0
         */

        public function acfBlocks() : void
        {
            if (!function_exists('acf_register_block')) {
                return;
            }

            $blocks = $this->blocks;

            foreach ($blocks as $perKey => $perBlock) {
                acf_register_block(
                    [
                        'name'            => data_get($perBlock, 'name'),
                        'title'           => data_get($perBlock, 'title'),
                        'description'     => data_get($perBlock, 'title'),
                        'render_callback' => [$this, 'renderAcfCallback'],
                        'category'        => 'formatting',
                        'icon'            => 'format-aside',
                        'keywords'        => ['optimisthub', str_replace(' ', ',', data_get($perBlock, 'name'))],
                        'supports'        => [
                            'className'
                        ]
                    ]
                );
            }
        }

        /**
         * Define Options Page
         * @version 1.0
         */

        public function acfOptions() : void
        {
            if (!function_exists('acf_add_options_page')) {
                acf_add_options_page();
            }

            acf_add_options_page(
                [
                    'page_title'    => 'OptimistHub',
                    'menu_title'    => 'OptimistHub',
                    'menu_slug'     => 'theme-general-settings',
                    'capability'    => 'edit_posts',
                    'icon_url'      => 'dashicons-plugins-checked', 
                    'redirect'      => false
                ]
            );
        }

        /**
         * Render Dynamic Gutenberg block template
         * @version 1.0
         */

        public function renderAcfCallback($block, $content = '', $is_preview = false) : void
        {
                
            $blockName = data_get($block, 'name');

            $classes = '';
    
            if( !empty($block['className']) ) {
                $classes .=  $block['className'];
            }

            
            $blockName = str_replace('acf/', '', $blockName);
            $context                = Timber::context();
            $context['block']       = $block;
            $context['fields']      = get_fields();
            $context['classname']   = $classes; 
            
            $context['is_preview']  = $is_preview;  
    
            Timber::render('blocks/'.$blockName.'-block.twig', $context);
        }
        /**
         * Admin styles for backend editor.
         */
        public function adminStyle() : void
        {
            echo '
                    <style>
                        /* Main column width */
                        .wp-block {
                            max-width: 100% !important;
                        }
            
                        /* Width of "wide" blocks */
                        .wp-block[data-align="wide"] {
                            max-width: 1080px;
                        }
            
                        /* Width of "full-wide" blocks */
                        .wp-block[data-align="full"] {
                            max-width: none;
                        }	
                        .populer-products { background:#f2f2f2;display:flex;align-items:center;text-align:center;width:100%; }
                        .populer-products .row.justify-item-list{ display:flex;justify-content: space-between;}
                        .populer-products .col { padding:20px }
                        .productivity-container{background-color:#f2f2f2;padding:40px 0}.productivity-container__item{display:flex;align-items:center}.productivity-container__item__icon{margin-right:20px}.productivity-container__item__icon img{width:90px}.productivity-container__item__text h2{font-size:1.4rem;font-weight:600;letter-spacing:-1px}.productivity-container__item__text h3{font-size:1.1rem}.productivity-container__item:hover img{transform:rotate(-4deg)}
                    </style>
                ';
        }

    }