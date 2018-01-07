<?php

class deactivateMyAccont_CriteriaUserEvent {
	public static function locked($rule, array $data, array $user, &$returnValue){
		if($rule != 'is_account_locked')
			;
		else if(!$user['user_id'])
			;
		else if($user['user_deactivated_kiroraddon']==1)
			$returnValue = true;
		return;
	}
	public static function unlocked($rule, array $data, array $user, &$returnValue){
		if($rule != 'is_account_unlocked')
			;
		else if(!$user['user_id'])
			;
		else if($user['user_deactivated_kiroraddon']==0)
			$returnValue = true;
		return;
	}
}
