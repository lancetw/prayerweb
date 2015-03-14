<?php
  class XUtil {

    public static function makeQlink($name)
    {
      sleep(2);

      $t = (int) (microtime(true));

      return Hashids::encode($t);

    }


  }
?>
