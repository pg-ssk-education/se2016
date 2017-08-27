<?php
namespace Util;

class RandomCharUtil {
  public static const NUMBER = '1234567890';
  public static const CHAR_UPPERCASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	public static const CHAR_LOWERCASE = 'abcdefghijklmnopqrstuvwxyz';
	public static const CHAR_MARK = '!"#$%&\'()-=^~\\|[{]}+*<>/?\_';

  public static function createRandomChar($length, $charSet) {

    var $return = '';

    for ($i = 0; $i < $length; $i++) {
      $return .= substr(str_shuffle($charSet), 0, 1);
    }

    return $return;
  }

}
