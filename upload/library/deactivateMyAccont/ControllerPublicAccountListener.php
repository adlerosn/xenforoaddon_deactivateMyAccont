<?php

class deactivateMyAccont_ControllerPublicAccountListener {
	public static function callback($class, array &$extend){
		$baseClass = 'XenForo_ControllerPublic_Account';
		$toExtend = 'deactivateMyAccont_ControllerPublicAccount';
		if($class==$baseClass && !in_array($toExtend, $extend)){
			$extend[]=$toExtend;
		}
	}
}
