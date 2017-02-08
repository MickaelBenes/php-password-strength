class PasswordTest {

	const PWDSTR_JOKE		= 1;
	const PWDSTR_VERYWEAK	= 2;
	const PWDSTR_WEAK		= 3;
	const PWDSTR_MEDIUM		= 4;
	const PWDSTR_STRONG		= 5;
	const PWDSTR_VERYSTRONG	= 6;
	
	private $_pwd;
	
	public function __construct( $sPassword ) {
		$this->_pwd = $sPassword;
	}

	public function getPasswordStrength() {
		$bHasNumeric	= false;
		$bHasLower		= false;
		$bHasUpper		= false;
		$bHasSpecials	= false;
		
		for ( $i = 0; $i < strlen($this->_pwd); $i++ ) {
			$char = $this->_pwd[ $i ];
			
			if ( is_numeric($char) ) {
				$bHasNumeric = true;
			}
			else if ( ctype_lower($char) ) {
				$bHasLower = true;
			}
			else if ( ctype_upper($char) ) {
				$bHasUpper = true;
			}
			else if ( preg_match('¤\W¤', $char) ) {
				$bHasSpecials = true;
			}
		}

		// contains digits and lowercase and uppercase letters and special characters
		if ( $bHasNumeric && $bHasLower && $bHasUpper && $bHasSpecials ) {
			return self::PWDSTR_VERYSTRONG;
		}

		// contains digits and lowercase and uppercase letters
		if ( $bHasNumeric && $bHasLower && $bHasUpper ) {
			return self::PWDSTR_STRONG;
		}

		// contains both lowercase and uppercase letters
		if ( !$bHasNumeric && $bHasLower && $bHasUpper ) {
			return self::PWDSTR_MEDIUM;
		}
		
		// contains digits and letters (uppercase or lowercase)
		if ( $bHasNumeric && (($bHasLower && !$bHasUpper) || (!$bHasLower && $bHasUpper)) ) {
			return self::PWDSTR_WEAK;
		}

		// contains only letters (uppercase or lowercase)
		if ( ctype_lower($this->_pwd) || ctype_upper($this->_pwd) ) {
			return self::PWDSTR_VERYWEAK;
		}

		// contains only digits
		if ( is_numeric($this->_pwd) ) {
			return self::PWDSTR_JOKE;
		}
	}
	
}
