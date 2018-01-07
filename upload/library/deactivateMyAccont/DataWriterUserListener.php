<?php

class deactivateMyAccont_DataWriterUserListener{
	public static function callback($class, array &$extend){
		$baseClass = 'XenForo_DataWriter_User';
		$toExtend = 'deactivateMyAccont_DataWriterUser';
		if(($class==$baseClass || in_array($baseClass, $extend)) && !in_array($toExtend, $extend)){
			$extend[]=$toExtend;
		}
	}
}
