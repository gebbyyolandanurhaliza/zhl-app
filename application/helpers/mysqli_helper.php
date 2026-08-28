<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------
  /**
   * Read the next result
   *
   * @return  null
   */   
  function next_result()
  {
    if (is_object($this->conn_id))
    {
      return mysqli_next_result($this->conn_id);
    }
    ELSE{
        echo 'ERROR';
    }
  }
  // -------------------------------------------------------------------- 