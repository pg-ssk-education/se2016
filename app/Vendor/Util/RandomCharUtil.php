<?php
namespace Util;

class RandomCharUtil {
  public const NUMBER    = "n";
  public const UPPERCASE = "u";
  public const LOWERCASE = "l";
  public const MARK      = "m";
  public const ALPHABET  = "ul";
  public const ALNUM     = "nul";
  public const ALL       = "nulm";

	private const CHAR_UPPERCASE = ;
	private const CHAR_LOWERCASE = '';
	private const CHAR_MARK = '!"#$%&\'()-=^~\\|[{]}+*<>/?\_';

  public function createRandomChar($length, $type) {
		$char = '';
    if (mb_strpos($type, self.NUMBER) !== false) {
      $char .= '1234567890';
    }
    if (mb_strpos($type, self.UPPERCASE) !== false) {
      $char .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if (mb_strpos($type, self.LOWERCASE) !== false) {
      $char .= 'abcdefghijklmnopqrstuvwxyz';
    }
    if (mb_strpos($type, self.NUMBER) !== false) {
      $char .= '1234567890';
    }

		if (in_array('alnum', $type)) {
			$char .= self.CHAR_UPPERCASE;
			$char .= self.CHAR_LOWERCASE;
		} else {
			if (in_array('num', $type)) {
				$char .= self.CHAR_NUM;
			}
			if (in_array('al', $type)) {
				$char .= self.CHAR_UPPERCASE;
				$char .= self.CHAR_LOWERCASE;
			} else if (in_array('uc', $type)) {
				$char .= self.CHAR_UPPERCASE;
			} else if (in_array('lc', $type)) {
				$char .= self.CHAR_LOWERCASE;
			}
		}
		if (in_array('mark', $type)) {
			$char .= self.CHAR_MARK;
		}

		$result = '';
		for ($i = 0; $i < $length; $i++) {
			$result .= mb_substr($char, mb_rand(0, $mb_strlen($char) - 1), 1);
		}

		return $result;
	}
}
