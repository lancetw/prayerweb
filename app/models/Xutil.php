<?php
  class XUtil {

    public static function makeQlink($name)
    {
      usleep(1100000);
      return Hashids::encode((int) (microtime(true)));
    }

  }
?>
