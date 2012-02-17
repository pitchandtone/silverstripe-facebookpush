<?php
/**
 * class to send message to Facebook.
 */
class PostToFacebook extends Controller {

	private static $facebook_access_token;

	private static $facebook_app_id;

	private static $facebook_secret;

	private static $facebook_user_id;

	protected static function get_facebook_access_token() {
		return self::$facebook_access_token;
	}

	protected static function get_facebook_app_id() {
		return self::$facebook_app_id;
	}

	protected static function get_facebook_secret() {
		return self::$facebook_secret;
	}

	protected static function get_facebook_user_id() {
		return self::$facebook_user_id;
	}

	public static function set_facebook_access_token($key) {
		self::$facebook_access_token = $key;
	}

	public static function set_facebook_app_id($key) {
		self::$facebook_app_id = $key;
	}

	public static function set_facebook_secret($key) {
		self::$facebook_secret = $key;
	}

	public static function set_facebook_user_id($key) {
		self::$facebook_user_id = $key;
	}

	public function __construct() {
		if (!isset(self::$facebook_access_token)) {
			$config = SiteConfig::current_site_config();
			if ($config->FacebookAccessToken) {
				self::set_facebook_access_token($config->FacebookAccessToken);
			}
			if ($config->FacebookAppID) {
				self::set_facebook_app_id($config->FacebookAppID);
			}
			if ($config->FacebookAppSecret) {
				self::set_facebook_secret($config->FacebookAppSecret);
			}
			if ($config->FacebookUserId) {
				self::set_facebook_user_id($config->FacebookUserId);
			}
		}
		parent::__construct();
	}

	public function sendToFacebook($params){

		// create instance
		$facebook = new Facebook(array(
			'appId'  => self::get_facebook_app_id(),
			'secret' => self::get_facebook_secret(),
		));

		$facebook->setAccessToken(self::get_facebook_access_token());

		$result = $facebook->api(
			'/'.self::get_facebook_user_id().'/feed/',
			'post',
			$params
		);

		return $result;
	}

}