<?php
  class XUtil {

    public static function makeQlink($name)
    {
      $t = microtime(true) * 10000;
      $hashids = Hashids::encode($t);
      return $hashids;
    }


  }
?>
