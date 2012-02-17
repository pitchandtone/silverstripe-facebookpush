<?php
class FacebookSiteConfigMixin extends DataObjectDecorator {

	public function extraStatics() {
		return array(
			'db' => array(
				'FacebookAccessToken' 			=> 'Varchar(255)',
				'FacebookAppId' 						=> 'Varchar(255)',
				'FacebookAppSecret' 				=> 'Varchar(255)',
				'FacebookUserId' 						=> 'Varchar(255)',
			)
		);
	}

	public function updateCMSFields(FieldSet &$fields) {
		$fields->addFieldsToTab('Root.SocialMedia', 	new TextField('FacebookAccessToken', 'Facebook access token'));
		$fields->addFieldsToTab('Root.SocialMedia', 	new TextField('FacebookAppId', 'Facebook app ID'));
		$fields->addFieldsToTab('Root.SocialMedia', 	new PasswordField('FacebookAppSecret', 'Facebook app Secret'));
		$fields->addFieldsToTab('Root.SocialMedia', 	new TextField('FacebookUserId', 'Facebook user/page ID'));
		return $fields;
	}

}
?>