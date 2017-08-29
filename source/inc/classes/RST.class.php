<?php

/**
 * Core class of RED Starter Theme
 *
 * @package     WordPress
 * @subpackage  RED Starter Theme
 * @since       1.0.0
 * @author      Luke Kortunov
 */
class RST {

  /**
   * It will crop string to specified length and add "..."
   *
   * @param $str  string  - source string, need to be cropped
   * @param $len  int     - number of chars, that you need, included "..."
   * @param $echo bool    - false==return | true == echo
   * @param $dots bool    - include "..." to output? default: yes (true)
   *
   * @return string|void - cropped string
   *
   * @since       1.0.0
   * @author      Luke Kortunov
   */
  public static function crop_text( $str, $len, $echo = false, $dots = true ) {
    if( mb_strlen( $str ) > $len ) {
      if( $dots == true ) {
        $res = mb_substr( $str, 0, ( $len - 3 ) );
        $res = $res . "...";
      } else {
        $res = mb_substr( $str, 0, $len );
      }
    } else {
      $res = $str;
    }

    if( $echo == true ) {
      echo $res;
      return false;
    }

    return $res;
  }



  /**
   * Function, that require svg-file and return or print it
   *
   * @param string  $filename - file name excluding file extension
   * @param bool    $return   - true == include file || false == return path
   * @param string  $dir      - if svg files directory not eq. "svg" - set target directory related to theme root
   *
   * @return null|string
   *
   * @since       1.0.0
   * @author      Luke Kortunov
   */
  public static function svg( $filename, $return = false, $dir = 'assets/build/svg' ) {
    $dir = mb_substr( $dir, 0, 1 ) == '/' ? mb_substr( $dir, 1, mb_strlen( $dir ) ) : $dir;
    $dir = mb_substr( $dir, -1, 1 ) == '/' ? mb_substr( $dir, 0, mb_strlen( $dir ) - 1 ) : $dir;
    $path = get_template_directory() . '/' . $dir . '/' . $filename . '.svg';
    if( $return == false ) {
      @require $path;
    } else {
      return $path;
    }

  }

}
