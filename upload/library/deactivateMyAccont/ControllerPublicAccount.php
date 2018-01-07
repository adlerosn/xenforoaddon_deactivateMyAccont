<?php

class deactivateMyAccont_ControllerPublicAccount extends XFCP_deactivateMyAccont_ControllerPublicAccount{
	public function actionDeactivate(){
		return $this->_getWrapper(
			'account',
			'deactivate',
			$this->responseView(
				'XenForo_ViewPublic_Base',
				'account_deactivate_kiror',
				array('firstscreen'=>true)
			)
		);
	}
	public function actionDeactivateConfirmation(){
		return $this->_getWrapper(
			'account',
			'deactivate',
			$this->responseView(
				'XenForo_ViewPublic_Base',
				'account_deactivate_kiror',
				array('firstscreen'=>false)
			)
		);
	}
	public function actionDeactivateSave(){
		$this->_assertPostOnly();
		$visitor = XenForo_Visitor::getInstance();
		$uid = $visitor->user_id;
		if(!$uid){
			return $this->responseRedirect(
				XenForo_ControllerResponse_Redirect::SUCCESS,
				XenForo_Link::buildPublicLink('')
			);
		}
		//*
		//checking password
		$visitorPassword = $this->_input->filterSingle('visitor_password', XenForo_Input::STRING);
		$auth = $this->_getUserModel()->getUserAuthenticationObjectByUserId($uid);
		if (!$auth || !$auth->authenticate($uid, $visitorPassword)){
			return $this->responseError(new XenForo_Phrase('your_existing_password_is_not_correct'));
		}
		//checking if not staff
		if($visitor->is_staff || $visitor->is_moderator || $visitor->is_admin || $visitor->isSuperAdmin()){
			return $this->responseError(new XenForo_Phrase('kiror_accdeact_staff_err'));
		}
		//*/
		//setting privacy settings
		$writer = XenForo_DataWriter::create('XenForo_DataWriter_User');
		$writer->setExistingData($uid);
		$settings = array(
			'user_deactivated_kiroraddon'      => 1,
			'receive_admin_email'              => 1,
			'email_on_conversation'            => 0,
			'visible'                          => 0,
			'activity_visible'                 => 0,
			'show_dob_date'                    => 0,
			'show_dob_year'                    => 0,
			'allow_view_profile'               => '',
			'allow_post_profile'               => '',
			'allow_send_personal_conversation' => '',
			'allow_view_identities'            => '',
			'allow_receive_news_feed'          => '',
		);
		if ($this->_isAddOnIdInstalledAndActivated('xfa_blogs')){
			$settings['allow_view_blog']='';
		}
		$writer->bulkSet($settings);
		$writer->save();
		$redirectResponse = $this->responseRedirect(
			XenForo_ControllerResponse_Redirect::SUCCESS,
			$this->getDynamicRedirect(false, false),
			new XenForo_Phrase('kiror_accdeact_done')
		);
		//*
		//reprocessing promotions
		$this->_executePromotionUpdate(true);
		//logging out
		$this->getModelFromCache('XenForo_Model_Session')->processLastActivityUpdateForLogOut(XenForo_Visitor::getUserId());
		XenForo_Application::get('session')->delete();
		XenForo_Helper_Cookie::deleteAllCookies(
			array('session'),
			array('user' => array('httpOnly' => false))
		);
		XenForo_Visitor::setup(0);
		//*/
		return $redirectResponse;
	}
	/**
	 * Check if some add-on is installed and activated.
	 * 
	 * @param addOnId string
	 * @return boolean
	 */
	protected function _isAddOnIdInstalledAndActivated($addOnId){
		$addon = $this->_getAddOnModel()->getAddOnById($addOnId);
		return (is_array($addon) && isset($addon['active']) && $addon['active']);
	}
	/**
	 * Gets the add-on model object.
	 *
	 * @return XenForo_Model_AddOn
	 */
	protected function _getAddOnModel()
	{
		return $this->getModelFromCache('XenForo_Model_AddOn');
	}
}
