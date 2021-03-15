<?php
class User
{
	static function login($username, $password)
	{
		// check if user
		$where = array(
            'AND' => array(
                'username' => $username,
                'password' => $password
            )
        );
		$users = DB::select('system_user', '*', $where);
		
		if (count($users) != 1)
		{
			return false;
		}
        $user = $users[0];

		// login successful
		SC::setSession('id', $user['id']);
		SC::setSession('username', $user['username']);
		SC::setSession('role', $user['role']);
		SC::setSession('is_login', true);

		return $user;
	}

	static function logout()
	{
        $scname_list = array('id', 'username', 'role' ,'is_login');
        foreach ($scname_list as $scname){
            SC::remove($scname);
        }

		// alway return true
		return true;
	}

	static function getCurrentUser()
	{
		if(!self::isLogin()){
            return null;
        }

        $id = SC::get('id');
        $user = DB::get('system_user', '*', array('id' => $id));
		return $user;
	}

	static function getCurrentUserID()
	{
		$id = SC::get('id');

		if(is_null($id))
			return -1;

		return $id;
	}

	static function getCurrentUsername()
	{
		return SC::get('username');
	}

	static function getCurrentRole()
	{
		return SC::get('role');
	}

	static function isLogin()
	{
		return SC::get('is_login');
	}

	static function register($username, $password, $role, $additions_data = array())
	{
		global $_REQUEST;

		// check data
		$username = trim($username);

		$where = array('username' => $username);
		$user_data = DB::get('system_user', '*', $where);
		if (count($user_data) > 0){
            return 'Duplicate username';
        }

		// prepare data
		$data = array(
			'username' => $username,
			'password' => $password,
			'role' => $role
		);
		foreach($additions_data as $key => $value)
			$data[$key] = $value;

		$user_id = DB::insert('system_user', $data);

		$user = DB::get('system_user', '*', array('id' => $user_id));
		return $user;
	}

	static function update($user_id, $data)
	{
		$user = DB::get('system_user', '*', array('id' => $user_id));

		// check user exists
		if (!$user)
		{
			return false; // user not existed
		}

		// check $data
		if(isset($data['username']))
			unset($data['username']);
		if(isset($data['password']))
		{
			if('' == $data['password'])
				unset($data['password']);
		}
		if(isset($data['role']))
			unset($data['role']);

		// operate
		$where = array('id' => $user_id);
		$result = DB::update('system_user', $data, $where);

		if(!$result)
			return false; // error

		return true;
	}

	static function updatePassword($user_id, $new_password)
	{
		$user = DB::get('system_user', '*', array('id' => $user_id));

		// check user exists
		if (!$user)
		{
			return false; // user not existed
		}

		// operate
		$data = array('password' => $new_password);
		$where = array('id' => $user_id);
		$result = DB::update('system_user', $data, $where);

		if(!$result)
			return false; // error

		return true;
	}
}
?>