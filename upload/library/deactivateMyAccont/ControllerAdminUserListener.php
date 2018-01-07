<?php

class deactivateMyAccont_ControllerAdminUserListener {
	public static function callback($class, array &$extend){
		$baseClass = 'XenForo_ControllerAdmin_User';
		$toExtend = 'deactivateMyAccont_ControllerAdminUser';
		if($class==$baseClass && !in_array($toExtend, $extend)){
			$extend[]=$toExtend;
		}
	}
}
