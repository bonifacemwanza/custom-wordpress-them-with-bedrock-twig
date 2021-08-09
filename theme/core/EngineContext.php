<?php 

    /**
     * Timber Context
     * @version 1.0
     * @author Fatih Toprak
     */
 
	use Timber\URLHelper;
	use DeviceDetector\DeviceDetector;
	use DeviceDetector\Parser\Device\AbstractDeviceParser;
	AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);
	use InstagramScraper\Instagram;
	use Phpfastcache\Helper\Psr16Adapter;
		
	class EngineContext extends Timber\Site {

		private $userAgent = null;
		private $context = null;

		public function __construct() {
			add_filter( 'timber/context', [$this, 'add_to_context'] ); 
			$this->userAgent = $_SERVER['HTTP_USER_AGENT'];
            parent::__construct();
		}  

		public function add_to_context( $context ) 
        {

			global $woocommerce; 
			global $product;

			$dd = new DeviceDetector($this->userAgent);
			$dd->parse();

			## Requests
			$context['request']			= [
				'current_url' 	=> URLhelper::get_current_url(),
				'url_params' 	=> URLHelper::get_params(),
				'is_mobile' 	=> $dd->isSmartphone(),
			];

			$context['config'] = $this->getOptions();
			$context['asset_dir'] = $this->assetDir(get_bloginfo('template_url')); 
			$context['search_query'] = get_search_query(); 
			$context['header_menu'] = $this->renderMenu('primary_menu');
			$context['footer_menu'] =  $this->renderMenu('footer_menu');
			$context['recent_products'] = $this->getRecentProducts();
			$context['recent_blogposts'] = $this->getRecentPosts();
			$context['instagram_feed'] = \Timber\Helper::transient( 'feed_insta', function() {
					return $this->fetcInstagramFeedX(); 
			}, HOUR_IN_SECONDS );
 
			#ray($context);

			$context['site'] = $this;  
			return $context;
        }

		private function assetDir($url)
		{
			return str_replace('/themes/ecommerce/theme', '/themes/ecommerce/static', $url);
		}

		private function getRecentProducts()
		{
			$posts = \Timber\Helper::transient( 'recent_products', function() {
				return Timber::get_posts( 
					[
						'post_type'     => 'product',
						'posts_per_page' => 6,
						'order_by' => 'rand', 
						'order' => 'DESC'
					] 
				);
			}, HOUR_IN_SECONDS ); 

			return $posts;
		}

		private function getRecentPosts()
		{
			$posts = \Timber\Helper::transient( 'recent_blog_posts', function() {
				return Timber::get_posts( 
					[
						'post_type'     => 'post',
						'posts_per_page' => 6,
						'order' => 'DESC'
					] 
				);
			}, HOUR_IN_SECONDS );

			return $posts;
		}

		private function fetcInstagramFeed()
		{
 
			$posts = \Timber\Helper::transient( 'instagram_feed', function() {
				if(!data_get($this->getOptions(),'instagram_username') && !data_get($this->getOptions(),'instagram_password'))
				{
					return;
				} 
				/*

				$instagram  = Instagram::withCredentials(new \GuzzleHttp\Client(), data_get($options,'instagram_username'), data_get($options, 'instagram_password'), new Psr16Adapter('Files'));
				$instagram->login();
				$instagram->saveSession();

				$posts  = $instagram->getFeed();
				return $posts;
				*/

				$instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
				$nonPrivateAccountMedias = $instagram->getMedias(data_get($this->getOptions(),'instagram_username'));
				foreach ($nonPrivateAccountMedias as $key => $value) {
					$media = data_get($value, 'imageThumbnailUrl');
					file_put_contents(str_replace('web/wp/','web/',ABSPATH). '/temp-cache/instagram-feed.'.$key.'.jpg',file_get_contents($media)); 
				}
				return $nonPrivateAccountMedias;
				

			}, HOUR_IN_SECONDS );
			
			return $posts;
			 
		}

		// private function fetcInstagramFeedX()
		// {
 
		// 	## TODO : Will Change Username Etc.
		// 	$instagram  = Instagram::withCredentials(new \GuzzleHttp\Client(), 'fatihtoprakk', 'pozreaction1', new Psr16Adapter('Files'));
		// 	$instagram->login();
		// 	$instagram->saveSession();

		// 	$nonPrivateAccountMedias = $instagram->getMedias(data_get($this->getOptions(),'instagram_username'));
			

		// 	foreach ($nonPrivateAccountMedias as $key => $value) {
		// 		$media = data_get($value, 'imageThumbnailUrl');
		// 		file_put_contents(str_replace('web/wp/','web/',ABSPATH). '/temp-cache/instagram-feed.'.$key.'.jpg',file_get_contents($media)); 
		// 	}

		// 	return $nonPrivateAccountMedias;
 
			 
		// }

		private function getOptions()
		{
			$return = \Timber\Helper::transient( 'site_options', function() {
				return get_fields('options');
			}, HOUR_IN_SECONDS ); 

			return $return;
		}

		private function renderMenu($slug)
		{
			$return = \Timber\Helper::transient( 'optimist_menu', function() {
				return [
					'primary_menu' => new Timber\Menu('primary_menu'),
					'footer_menu' => new Timber\Menu('footer_menu'),
				];
			}, HOUR_IN_SECONDS ); 

			return $return[$slug];
		}

	} 
    

