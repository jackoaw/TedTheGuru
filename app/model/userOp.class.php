<?php
	class userOp
	{
	
		// Based on the given ID and new content it will modify the associated user's name
		public function modifyName($Num, $newContent)
		{
			$db = db::instance();
			$db->modifyUserNameByNum('users', $Num, $newContent);
		}

		// Based on the given ID and new content it will modify the associated user's password
		public function modifyPassword($Num, $newContent)
		{
			$db = db::instance();
			$db->modifyUserPasswordByNum('users', $Num, $newContent);
		}

		// Based on the given ID and new content it will modify the associated user's birthday
		public function modifyBirthday($Num, $month, $day, $year)
		{
			$db = db::instance();
			$date = date("Y-m-d", mktime(0,0,0,$month, $day, $year));
			$db->modifyUserBirthdayByNum('users', $Num, $date);
		}

		// Based on the given ID and new content it will modify the associated user's About me
		public function modifyAboutMe($Num, $newContent)
		{
			$db = db::instance();
			$db->modifyUserAboutMeByNum('users', $Num, $newContent);
		}

		// Based on the given ID delete the account
	public function deleteAccount($Num)
	{
		$db = db::instance();
		$db->removeById('users', $Num);
	}

	public function modifyAdmin($Num, $adminBoolean) {
		$db = db::instance();
		$db->modifyUserAdminByNum('users', $Num, $adminBoolean);
	}
	
}