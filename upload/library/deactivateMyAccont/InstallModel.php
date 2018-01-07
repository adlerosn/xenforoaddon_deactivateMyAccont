<?php

class deactivateMyAccont_InstallModel extends XenForo_Model {
	public function install(){
		$q = 'ALTER TABLE xf_user ADD user_deactivated_kiroraddon BOOLEAN DEFAULT 0;';
		$this->_getDb()->query($q);
	}
	public function uninstall(){
		$q = 'ALTER TABLE xf_user DROP COLUMN user_deactivated_kiroraddon;';
		$this->_getDb()->query($q);
	}
}
