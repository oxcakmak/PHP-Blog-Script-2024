<?php
/*
* Title: Hepa PHP Function Class
* Description: Function class that contains useful and useful codes for applications you have developed with php
* Author: Osman CAKMAK
* Username: oxcakmak
* Email: info@oxcakmak.com
* Website: https://oxcakmak.com/
* Version: 1.9
*/
/*
* # ABBREVIATION #
* s: String
* a: Array
* d: Date
* tm: time
* t: Type
* w: With
* f: Float
* fv: Float Value
* dt: Data Type
* db: Database
* val: Value
* cv: Convert
* cc: Calculate
* chk: Check
* clr: Clear
* del: Delete
* upd: Update
* ct: Custom
* rd: Random
* w: Way
* h: Hash
* cl: Color
* num: Number
* crt: Create
* gnt: Generate
* shr: Short
* fl: File
* sz: Size
* cnt: Count
* ctn: Contain
* cts: Contains
* addr: Address
* wrt: Write
* ctt: Content
* re: re-
* rwc: Rewrite Content
* l: Latest
* eq: Equal
* neq: Not Equal
* bigval: Big Value
* smaval: Small Value
* id: Id
* 

*/


/*
* Description: String
* Usage: $hepa->function(string);
* Example: $hepa->function(string);
*/
class hepa {
	
	/*
	* Description: Checks if a string starts with the specified target
	* Usage: $hepa->chkctStart($string, $target);
	* Example:  $hepa->chkctStart("abcde", "abc");
	*/
	public function chkctStart($str, $target, int $position = null){
		$length = strlen($str);
		$position = null === $position ? 0 : +$position;
		if ($position < 0) {
			$position = 0;
		} elseif ($position > $length) { $position = $length; }
		return $position >= 0 && substr($str, $position, strlen($target)) === $target;
	}
	/*
	* Description: Checks if a string ends with the specified target
	* Usage: $hepa->chkctEnd($string, $target);
	* Example:  $hepa->chkctEnd("abcde", "abc");
	*/
	public function chkctEnd($str, $target, int $position = null){
		$length = strlen($str);
		$position = null === $position ? $length : +$position;
		if ($position < 0) { $position = 0; } elseif ($position > $length) { $position = $length; }
		$position -= strlen($target);
		return $position >= 0 && substr($str, $position, strlen($target)) === $target;
	}
	/*
	* Description: Converts a string to UTF-8 encoding type accordingly.
	* Usage: $hepa->cvs2Utf8($string);
	* Example:  $hepa->cvs2Utf8("abcde");
	*/
	public function cvs2Utf8($str){ return iconv(mb_detect_encoding($str, mb_detect_order(), true), "UTF-8", $str); }
	/*
	* Description: Clears illegal characters in a string
	* Usage: $hepa->sclr($string);
	* Example:  $hepa->sclr("abcde");
	*/
	public function sclr($str){ return htmlspecialchars(strip_tags(stripslashes(trim($str))), ENT_QUOTES, 'UTF-8'); }
	/*
	* Description: Cleans up characters in a string that could lead to an invalid xss vulnerability
	* Usage: $hepa->sXssclr($string);
	* Example:  $hepa->sXssclr("<script>alert('test');</script>");
	*/
	public function sXssclr($str){ return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
	
	/*
	* Description: Random color hex code generation way 1
	* Usage: $hepa->rdwHexcl1();
	* Example:  $hepa->rdwHexcl1();
	*/
	public function rdwHexcl1(){ return str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT); }
	/*
	* Description: Random color hex code generation way 2
	* Usage: $hepa->rdwHexcl2();
	* Example: $hepa->rdwHexcl2();
	*/
	public function rdwHexcl2(){ return sprintf('%06X', mt_rand(0, 0xFFFFFF)); }
	/*
	* Description: Generate a random floating digit number.
	* Usage: $hepa->genRandNum(lower, upper, floating);
	* Example: $hepa->function(0, 100, true); 
	* ! You can specify true or false if you wish. !
	*/
	public function gntrndnumwf($lower = null, $upper = null, $floating = null){
		if (null === $floating) {
			if (is_bool($upper)) {
				$floating = $upper;
				$upper = null;
			} elseif (is_bool($lower)) {
				$floating = $lower;
				$lower = null;
			}
		}
		if (null === $lower && null === $upper) {
			$lower = 0;
			$upper = 1;
		} elseif (null === $upper) {
			$upper = $lower;
			$lower = 0;
		}
		if ($lower > $upper) {
			$temp = $lower;
			$lower = $upper;
			$upper = $temp;
		}
		$floating = $floating || (is_float($lower) || is_float($upper));
		if ($floating || $lower % 1 || $upper % 1) {
			$randMax = mt_getrandmax();
			return $lower + abs($upper - $lower) * mt_rand(0, $randMax) / $randMax;
		}
		return rand((int) $lower, (int) $upper);
    }
	/*
	* Description: Calculate file size
	* Usage: $hepa->ccflsz($size);
	* Example:  $hepa->ccflsz("1874080");
	*/
	public function ccflsz($size){
        if ($size < 1024){ return $size . ' B'; }else{
			$size = $size / 1024;
			$units = ["KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
			foreach ($units as $unit){ if(round($size, 2) >= 1024){ $size = $size / 1024; }else{ break; } }
			return round($size, 2) . ' ' . $unit;
		}
    }
	/*
	* Description: Checks the extensions of the entered e-mail addresses (Blocks temporary e-mail addresses)
	* Initialize: $domains = array('gmail.com','yahoo.com','hotmail.com','outlook.com','msn.com','yandex.com');
	* Usage: $hepa->ccEmailctn($email, $domains);
	* Example:  $hepa->ccEmailctn("info@oxcakmak.com", $domains);
	*/
    public function ccEmailctn($email, $domains){
		foreach ($domains as $domain) { 
			$pos = @strpos($email, $domain, strlen($email) - strlen($domain));
			if ($pos === false){ continue; } 
			if ($pos == 0 || $email[(int) $pos - 1] == "@" || $email[(int) $pos - 1] == "."){ return 1;  } 
		}
		return 0;
	}
	/*
	* Description: Get client IP Addresss
	* Usage: $hepa->getClientIpaddr();
	* Example: $hepa->getClientIpaddr();
	*/
	public function getClientIpaddr(){
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote = @$_SERVER['REMOTE_ADDR'];
		if(filter_var($client, FILTER_VALIDATE_IP)){ $ip = $client; }
		elseif(filter_var($forward, FILTER_VALIDATE_IP)){ $ip = $forward;
		}else{ $ip = $remote; }
		return $ip;
    }
	/*
	* Description: Random String Generator
	* Usage: $hepa->gntcts(minLength[Number], maxLength[Number], useLower[true/false], useUpper[true/false], useNumbers[true/false], useSpecial[true/false]);
	* Example: $hepa->gntcts(0, 12, true, false, true, false);
	*/
	public function gntcts($minLength = 20, $maxLength = 20, $useLower = true, $useUpper = true, $useNumbers = true, $useSpecial = false) {
		$charset = '';
		if($useLower) { $charset .= "abcdefghijklmnopqrstuvwxyz"; }
		if($useUpper){ $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; }
		if($useNumbers){ $charset .= "123456789"; }
		if($useSpecial){ $charset .= "~@#$%^*()_+-={}|]["; }
		if($minLength > $maxLength){ $length = mt_rand($maxLength, $minLength); }else{ $length = mt_rand($minLength, $maxLength); }
		$key = '';
		for($i = 0; $i < $length; $i++){ $key .= $charset[(mt_rand(0, strlen($charset) - 1))]; }
		return $key;
	}
	/*
	* Description: Random String Generator
	* Usage: $hepa->gntrds(length);
	* Example: $hepa->gntrds(12);
	*/
	function gntrds($length) {
		$key = '';
		$keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}
		return $key;
	}
	/*
	* Description: Slugify string
	* Usage: $hepa->slugs(string);
	* Example: $hepa->slugs("Lorem Ipsum State");
	*/
	public function slugs($string){
		$preg = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',', '+', '#', '.', '_');
		$match = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','', '', '', '', '');
		$perma = strtolower(str_replace($preg, $match, $string));
		$perma = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $perma);
		$perma = trim(preg_replace('/\s+/', ' ', $perma));
		$perma = str_replace(' ', '-', $perma);
		return $perma;
	}
	/*
	* Description: Hash MD5 Sha1 MD5 Any string custom
	* Usage: $hepa->hsct(string);
	* Example: $hepa->hsct("1234");
	*/
	public function hsct($string){ return hash("md5", hash("sha256", hash("sha1", hash("crc32", $string)))); }
	/*
	* Description: Rewrite content
	* Usage: $hepa->rwc(string);
	* Example: $hepa->rwc("1234");
	*/
	public function rwc($string){ echo $string; }
	/*
	* Description: Hash value
	* Using: $hepa->hval("admin");
	* Output: 3095ee219dea85f67c1e3a87898c1d5f7b712d20
	*/
	public function hval($string){
		$string = hash("sha384", $string);
		$string = hash("md5", $string);
		$string = hash("sha512", $string);
		$string = hash("md5", $string);
		$string = hash("ripemd256", $string);
		$string = hash("md2", $string);
		$string = hash("md4", $string);
		$string = hash("md5", $string);
		$string = hash("adler32", $string);
		$string = hash("md5", $string);
		$string = hash("ripemd128", $string);
		$string = hash("md5", $string);
		$string = hash("crc32b", $string);
		$string = hash("md5", $string);
		$string = hash("ripemd160", $string);
		$string = hash("whirlpool", $string);
		$string = hash("sha256", $string);
		$string = hash("snefru", $string);
		$string = hash("ripemd320", $string);
		$string = hash("sha1", $string);
		$string = hash("crc32", $string);
		$string = hash("gost", $string);
		$string = hash("md2", $string);
		$string = hash("md4", $string);
		$string = hash("md5", $string);
		$string = hash("sha1", $string);
		return $string;
	}
	/*
	* Description: Latest Date
	* Using: $hepa->ld();
	* Output: 12.02.2020
	*/
	public function ld(){ return date("d.m.Y"); }
	/*
	* Description: Latest Date Time
	* Using: $hepa->ldtm();
	* Output: 12.02.2020-13:50
	*/
	public function ldtm(){ return date("d.m.Y-H:i"); }
	/*
    * Description: Equal
    * Using: $hepa->eq("pass", "pass");
    * Output: true_password
    */
	public function eq($varOne, $varTwo){
		if($varOne==$varTwo){ return true; }else{ return false; }
	}
	/*
    * Description: Not Equal
    * Using: $hepa->neq("pass", "pass123");
    * Output: false_password
    */
	public function neq($varOne, $varTwo){
		if($varOne!=$varTwo){ return true; }else{ return false; }
	}
	/*
    * Description: Equal Rewrite Content
    * Using: $hepa->eqrwc("pass", "pass", "true_password", "false_password");
    * Output: true_password
    */
	public function eqrwc($varOne, $varTwo, $eqTrue, $eqFalse){
		if($varOne==$varTwo){ $this->rwc($eqTrue); }else{ if($eqFalse){ $this->rwc($eqFalse); } }
	}
	/*
    * Description: Not Equal Rewrite Content
    * Using: $hepa->neqrwc("pass", "pass123", "false_password", "true_password");
    * Output: false_password
    */
	public function neqrwc($varOne, $varTwo, $eqFalse, $eqTrue){
		if($varOne!=$varTwo){ $this->rwc($eqFalse); }else{ if($eqTrue){ $this->rwc($eqTrue); } }
	}
	/*
    * Description: Big Value
    * Using: $hepa->bigval("1", "2");
    * Output: true_password
    */
	public function bigval($varOne, $varTwo){
		if($varOne>$varTwo){ return true; }else{ return false; }
	}
	/*
    * Description: Small Value
    * Using: $hepa->smaval("1", "2", "false_password", "true_password");
    * Output: false_password
    */
	public function smaval($varOne, $varTwo){
		if($varOne<$varTwo){ return true; }else{ return false; }
	}
	/*
    * Description: Big Value Rewrite Content
    * Using: $hepa->eqrwc("pass", "pass", "true_password", "false_password");
    * Output: true_password
    */
	public function bigvalrwc($varOne, $varTwo, $eqTrue, $eqFalse){
		if($varOne>$varTwo){ $this->rwc($eqTrue); }else{ if($eqFalse){ $this->rwc($eqTrue); } }
	}
	/*
    * Description: Small Value Rewrite Content
    * Using: $hepa->smavalrwc("pass", "pass123", "false_password", "true_password");
    * Output: false_password
    */
	public function smavalrwc($varOne, $varTwo, $eqFalse, $eqTrue){
		if($varOne<$varTwo){ $this->rwc($eqFalse); }else{ if($eqTrue){ $this->rwc($eqTrue); } }
	}
	/*
    * Description: Hash Custom String Id
    * Using: $hepa->hctsid("pass");
    * Output: 1005748453476574
    */
	function hctsid($str) {
		$stepTwo = hexdec(hash("crc32", $str));
		$stepThree = hexdec(hash("crc32b", $str));
		$stepFour = hexdec(hash("adler32", $str));
		$stepFive = time();
		$stepSix = mt_rand();
		$stepSeven = md5($str);
		$hid = preg_replace("/[a-zA-Z]/", "", ($stepTwo.$stepThree.$stepFour.$stepFive.$stepSix.$stepSeven));
		$hid = preg_replace("/(\d)\1+/", "$1", $hid);
		$hid = str_replace(['00', '11', '22', '33', '44', '55', '66', '77', '88', '99'], '', $hid);
		$hid = substr("1".$hid, 0, 20);
		return $hid;
	}
	/*
    * Description: Custom Json String
    * Using: $hepa->hctsid("pass");
    * Output: {"title":"Test","content":"Test message!", "type":"error"}
    */
	function ctJsons($title, $content, $type, $location = NULL, $interval = NULL){
		header("Content-Type: application/json", true);
		$json['title'] = $title;
		$json['content'] = $content;
		$json['type'] = $type;
		(($location)?$json['location'] = $location:"");
		(($interval)?$json['interval'] = $interval*1000:"");
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
	}
}
?>