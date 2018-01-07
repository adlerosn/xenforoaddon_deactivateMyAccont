<?php

class deactivateMyAccont_ControllerAdminUser extends XFCP_deactivateMyAccont_ControllerAdminUser{
	public function actionDeactivatedList(){
		$userId = $this->_input->filterSingle('user_id', XenForo_Input::UINT);
		if(!$userId){
			$criteria = $this->_input->filterSingle('criteria', XenForo_Input::JSON_ARRAY);
			$criteria = $this->_filterUserSearchCriteria($criteria);

			$filter = $this->_input->filterSingle('_filter', XenForo_Input::ARRAY_SIMPLE);
			if ($filter && isset($filter['value']))
			{
				$criteria['username2'] = array($filter['value'], empty($filter['prefix']) ? 'lr' : 'r');
				$filterView = true;
			}
			else
			{
				$filterView = false;
			}
			$showingAll = 0;
			$order = '';
			$direction = '';

			$page = 1;
			$usersPerPage = 999999999;

			$fetchOptions = array(
				'perPage' => $usersPerPage,
				'page' => $page,
				'order' => $order,
				'direction' => $direction,
			);

			$userModel = $this->_getUserModel();

			$criteriaPrepared = $this->_prepareUserSearchCriteria($criteria);

			$totalUsers = $userModel->countUsers($criteriaPrepared);

			$users_2 = $userModel->getUsers($criteriaPrepared, $fetchOptions);
			
			$users = array();
			foreach($users_2 as $u){
				if($u['user_deactivated_kiroraddon']){
					$users[]=$u;
				}
			}
			$totalUsers = count($users);

			$viewParams = array(
				'users' => $users,
				'totalUsers' => $totalUsers,
				'showingAll' => $showingAll,
				'showAll' => (!$showingAll && $totalUsers <= 5000),

				'linkParams' => array('criteria' => $criteria, 'order' => $order, 'direction' => $direction),
				'page' => $page,
				'usersPerPage' => $usersPerPage,

				'filterView' => $filterView,
				'filterMore' => ($filterView && $totalUsers > $usersPerPage)
			);

			return $this->responseView('XenForo_ViewAdmin_User_List', 'user_deactivated_list', $viewParams);
		}else{
			$writer = XenForo_DataWriter::create('XenForo_DataWriter_User', XenForo_DataWriter::ERROR_EXCEPTION);
			$writer->setExistingData($userId);
			$writer->set('user_deactivated_kiroraddon',0);
			$writer->save();
			return $this->responseRedirect(
				XenForo_ControllerResponse_Redirect::SUCCESS,
				XenForo_Link::buildAdminLink('users/edit',$this->_getUserModel()->getUserById($userId))
			);
		}
	}
}
