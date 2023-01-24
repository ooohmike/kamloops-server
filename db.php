<?php

//require_once( '../lib/db_cfg.php' );
require_once( 'config.php' );

//$db = db_connect();

$Wowza_Server_IP = '69.172.240.12';
//$Wowza_Server_IP = 'ec2-50-18-95-216.us-west-1.compute.amazonaws.com';

require_once( 'rawDB.php' );

function getPreviewImg( $mediaid )
{
  return PFS_VIDEOIMAGE;
}

function getFilename( $mediaid )
{
  global $mediaDB;
  return $mediaDB[$mediaid]['filename'];
}

function getRTSPurl ($mediaid)
{
  global $Wowza_Server_IP;
  $url = '';
  $filename = getFilename( $mediaid );
  switch( $mediaid )
  {
    case 0:
      $url = "rtsp://$Wowza_Server_IP/" . PFS_PUBPOINT . "/$filename"; break;
    default:
      $url = "rtsp://$Wowza_Server_IP/" . PFS_PUBPOINT . "/$filename"; break;
  }

  return $url;
	
}
function getHLSurl( $mediaid )
{
  global $Wowza_Server_IP;
  $url = '';
  $filename = getFilename( $mediaid );
  switch( $mediaid )
  {
    case 0:
      $url = "//$Wowza_Server_IP/" . PFS_PUBPOINT . "/$filename/playlist.m3u8"; break;
    default:
      $url = $filename; break;
  }

  return $url;
}

function getFLASHfile( $mediaid )
{
  return getFilename( $mediaid );
}

function getFLASHsrvr( $mediaid )
{
  global $Wowza_Server_IP;
  if( $mediaid == 0 )
    return "rtmp://$Wowza_Server_IP/" . PFS_PUBPOINT;
  else
    return '';
}

function getChapterList( $mediaid )
{
  global $db;

  $chapters = array();

  if( $mediaid == 0 )
    return $chapters;

  $mid = $db->quoteSmart( $mediaid );

  $sql = "SELECT id, offset, name FROM agenda_items WHERE mediaid = $mid AND broadcasterid=" . PFS_BROADCASTERID . " AND NOT deleted ORDER BY offset ASC;";

  $result = $db->getAll( $sql, array(), DB_FETCHMODE_ASSOC );
  if( PEAR::isError( $result ) )
  {
    error_log( "Chat::all: " . $result->GetMessage() );
    exit;
  }

  $msgs = '';
  foreach( $result as $agendaitem )
  {
    $chapter['name'] = $agendaitem['name'];
    $chapter['offset'] = $agendaitem['offset'];

    $chapters[] = $chapter;
  }

  return $result;
}

function getVideoInfo( $mediaid )
{
  global $mediaDB;

  return $mediaDB[$mediaid];
}

function getVideoList( $custid )
{
  global $mediaDB;

  $videos = array_reverse( $mediaDB, true );

  array_pop( $videos );

  $video = getVideoInfo( 0 );

  array_unshift( $videos, $video );

  return $videos;
}

?>
