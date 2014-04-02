<?php

foreach (glob(__DIR__."/lib/*.php") as $filename) {
  require $filename;
}
foreach (glob(__DIR__."/extensions/*.php") as $filename) {
  require $filename;
}
foreach (glob(__DIR__."/filters/*.php") as $filename) {
  require $filename;
}

class Lavender
{
  private static $_extensions = array();
  private static $_config = array(
    'file_extension' => 'lavender',
    'handle_errors'  => TRUE,
  );

  public static function config(array $config)
  {
    static::$_config = array_merge(static::$_config, $config);
  }

  public static function get_config($key)
  {
    return static::$_config[$key];
  }

  public static function view($name)
  {
    return new Lavender_View($name);
  }

  public static function register_filter($name, $class)
  {
    static::register_extension('filter|'.$name, $class);
  }

  public static function get_filter_by_name($name)
  {
    return static::get_extension_by_name('filter|'.$name);
  }

  public static function register_extension($name, $class, array $tokens = array())
  {
    static::$_extensions[] = array(
      'name'   => $name,
      'class'  => $class,
      'tokens' => $tokens,
    );
  }

  public static function get_extension_by_name($name)
  {
    foreach (static::$_extensions as $extension) {
      if ($extension['name'] == $name) {
        return new $extension['class'];
      }
    }

    return FALSE;
  }

  public static function get_extension_by_token($token)
  {
    foreach (static::$_extensions as $extension) {

      if (in_array($token, $extension['tokens'])) {
        return new $extension['class'];
      }
    }

    return FALSE;
  }
}