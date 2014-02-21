<?php

class Jade_Content
{
  public $_content;

  public function __construct($raw_content)
  {
    $this->_content = $raw_content;
  }

  public function consume_until($until)
  {
    $result = '';
    $until = str_split($until);

    while ($next = $this->peek()) {
      if (in_array($next, $until)) {
        break;
      } else {
        $result .= $this->consume_next();
      }
    }
    return $result;
  }

  public function consume_next($length = 1)
  {
    $result = substr($this->_content, 0, $length);
    $this->_content = substr($this->_content, $length);
    return $result;
  }

  public function consume_whitespace()
  {
    $start_length = strlen($this->_content);
    $this->_content = ltrim($this->_content, " \t");
    return $start_length - strlen($this->_content);
  }

  public function peek($index = 0)
  {
    if (!$this->_content) {
      return FALSE;
    }
    return substr($this->_content, $index, 1);
  }

  public function peek_until($until)
  {
    $result = '';
    $until = str_split($until);

    $i = 0;
    while ($next = $this->peek($i)) {
      if (in_array($next, $until)) {
        break;
      } else {
        $result .= $next;
      }
      $i++;
    }
    return $result;
  }
}
