<?php
class FacebookDecorator extends DataObjectDecorator {

	public function extraStatics() {
		return array(
			"db" => array(
				"LastPostedToFacebook" => "Varchar(255)"
			)
		);
	}

	public function updateCMSFields(&$fields) {
		$fields->addFieldToTab('Root.Content.SocialMedia', new CheckboxField('PostToFacebook', 'Post to Facebook'));
		$fields->addFieldToTab('Root.Content.SocialMedia', new ReadonlyField('LastPostedToFacebook', 'Last Posted To Facebook'));
	}

	public $PostToFacebook = false;

	public function setPostToFacebook($value) {
		$this->PostToFacebook = $value;
	}

	protected static $facebookField = array();

	public function getFacebookData() {
		foreach(self::$facebookField as $k => $v) {
			if($this->owner instanceof $k) {
				if($this->owner->$v) {
					return $this->owner->$v;
				} else {
					return $this->owner->$v();
				}
			}
		}
	}

	public function set_facebook_fields($fields = array()) {
		self::$facebookField = $fields;
	}

	public function onBeforeWrite(){
		if($this->getFacebookData() && $this->PostToFacebook) {
			$this->owner->LastPostedToFacebook = date('d/m/Y g:ia');
		}
	}

	public function onAfterWrite(){
		if($this->getFacebookData() && $this->PostToFacebook) {
			$params = $this->getFacebookData();
			$facebook = new PostToFacebook();
			$resp = $facebook->sendToFacebook($params);
			$this->PostToFacebook = false;
		}
	}

}