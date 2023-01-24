<?php

  // A series of functions useful for interaction with HTTP requests

  function safeGetHTTPParam_string( $param_name )
  {
    if( !isset( $_REQUEST[$param_name] ) )
    {
//      error_log( "$param_name not set in " . __FILE__ );
      return NULL;
    }

    $value = strval( $_REQUEST[$param_name] );

    if( !is_string( $value ) || ( 0 == strlen( $value ) ) )
    {
      error_log( "invalid $param_name=$value (expecting a string received a " . gettype( $value ) . ") in " . __FILE__ );
      return NULL;
    }

    return $value;
  }

  function safeGetHTTPParam_pos_int( $param_name )
  {
    if( !isset( $_REQUEST[$param_name] ) )
    {
//      error_log( "$param_name not set in " . __FILE__ );
      return NULL;
    }

    $value = $_REQUEST[$param_name];

    if( !is_numeric( $value ) )
    {
      error_log( "invalid $param_name=$value (expecting a pos int received a " . gettype( $value ) . ") in " . __FILE__ );
      return NULL;
    }

    $value = intval( $_REQUEST[$param_name] );

    if( !is_numeric( $value ) || ( !is_int( $value ) ) )
    {
      error_log( "invalid $param_name=$value (expecting a pos int received a " . gettype( $value ) . ") in " . __FILE__ );
      return NULL;
    }

    return $value;
  }

  function sendResult( $result, $allow_caching = false )
  {
    if( !$allow_caching )
    {
      // Results are dynamic, tell the recipient not to cache the results
      if( headers_sent( $file, $line ) )
      {
        error_log( "HTTP headers already sent from $file( $line )" );
      }
      else
      {
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate, proxy-revalidate, no-cache, no-store, max-age=0, s-maxage=0' );
      }
    }

//    $json = json_encode( $result, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP );
    $json = json_encode( $result );
    echo $json;
  }

?>
