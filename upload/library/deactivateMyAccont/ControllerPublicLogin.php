<?php

class deactivateMyAccont_ControllerPublicLogin extends XFCP_deactivateMyAccont_ControllerPublicLogin{
	public function actionLogin(){
		$r = parent::actionLogin();
		if(XenForo_Visitor::getUserId()) $this->_executePromotionUpdate(true);
		if(XenForo_Visitor::getUserId() && XenForo_Visitor::getInstance()['user_deactivated_kiroraddon']){
			//User provided good credentials, but account is locked
			//logging out
			$this->getModelFromCache('XenForo_Model_Session')->processLastActivityUpdateForLogOut(XenForo_Visitor::getUserId());
			XenForo_Application::get('session')->delete();
			XenForo_Helper_Cookie::deleteAllCookies(
				array('session'),
				array('user' => array('httpOnly' => false))
			);
			XenForo_Visitor::setup(0);
			//Returning error
			return $this->responseError(new XenForo_Phrase('kiror_accdeact_login_err'));
		}else{
			return $r;
		}
	}
}
