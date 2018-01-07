<?php

class deactivateMyAccont_DataWriterUser extends XFCP_deactivateMyAccont_DataWriterUser {
	protected function _getFields(){
		$f = parent::_getFields();
		$f['xf_user']['user_deactivated_kiroraddon'] = array('type' => self::TYPE_BOOLEAN, 'default' => 0);
		return $f;
	}
}
