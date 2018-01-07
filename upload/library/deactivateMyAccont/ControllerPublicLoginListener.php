<?php

class deactivateMyAccont_ControllerPublicLoginListener {
	public static function callback($class, array &$extend){
		$baseClass = 'XenForo_ControllerPublic_Login';
		$toExtend = 'deactivateMyAccont_ControllerPublicLogin';
		if($class==$baseClass && !in_array($toExtend, $extend)){
			$extend[]=$toExtend;
		}
	}
}
