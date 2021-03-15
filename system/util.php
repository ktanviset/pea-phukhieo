<?php
class Util {
	public static function redirect($url = '', $delay = 0) {
		if(! is_null($url)) {
			if ($url == ''){
				$url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			}
			header("Location: ".$url);
		}
		exit();
	}

	public static function console($data) {
		echo '<script>';
		echo 'console.log('. json_encode($data). ')';
		echo '</script>';
	}

	static function getClientIP() 
	{
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	static function formatMonthName($month_index, $full_name = true) {
		$months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$month_shorts = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec");

		// convert to number
		$month_index *= 1;

		$month_list = $full_name ? $months : $month_shorts;

		return isset($month_list[$month_index]) ? $month_list[$month_index] : "";
	}

	static function formatMonthNameTH($month_index, $full_name = true) {
		$months = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
		$month_shorts = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

		// convert to number
		$month_index *= 1;

		$month_list = $full_name ? $months : $month_shorts;

		return isset($month_list[$month_index]) ? $month_list[$month_index] : "";
	}
}
?>