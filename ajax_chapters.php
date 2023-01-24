<?php

  require_once 'http_util.php';

  require_once 'CChapters.php';

  // This file implements an AJAX server that responds to
  // un-authenticated queries.  This server will not modify
  // the DB in any way.

  function safeGetHTTPParam_mediaid()
  {
    return safeGetHTTPParam_pos_int( 'mediaid' );
  }

  function safeGetHTTPParam_offset()
  {
    return safeGetHTTPParam_pos_int( 'offset' );
  }

  function safeGetHTTPParam_chapterid()
  {
    return safeGetHTTPParam_pos_int( 'chapterid' );
  }

  function safeGetHTTPParam_cmd()
  {
    return safeGetHTTPParam_string( 'cmd' );
  }

  function safeGetHTTPParam_all()
  {
    return safeGetHTTPParam_pos_int( 'all' );
  }

  function safeGetHTTPParam_name()
  {
    return safeGetHTTPParam_string( 'name' );
  }

  // We accept GET and POST
  $mediaid = safeGetHTTPParam_mediaid();
  $cmd = safeGetHTTPParam_cmd();

  if( !isset( $mediaid, $cmd ) )
  {
    sendResult( 'Missing mediaid or command', false );
    exit;
  }

  $success = false;
  $result = NULL;

  $chapters = new CChapters();
  $chapters->init();

  switch( $cmd )
  {
    case 'liv':
      $result = $chapters->getChapterLive( $mediaid );
      break;

    case 'fnd':
      if( 0 == $mediaid )
      {
        $result = $chapters->getChapterLive( $mediaid );
      }
      else
      {
        $offset = safeGetHTTPParam_offset();
        if( isset( $offset ) ) $result = $chapters->findChapter( $mediaid, $offset );
      }
      break;

    case 'lst':
      $all = safeGetHTTPParam_all();
      if( 1 == $all )
        $posted = NULL;
      else
        $posted = true;

      $result = $chapters->getChapterList( $mediaid, $posted );
      break;

    case 'new':
      $name = safeGetHTTPParam_name();
      if( isset( $name ) ) $success = $chapters->newChapter( $mediaid, $name, 999999 );
      if( $success )
      {
        $result = $chapters->getChapterList( $mediaid, NULL );
      }
      else
      {
        $result = 'Error';
      }
      break;

    case 'snm':
      $chapterid = safeGetHTTPParam_chapterid();
      $name = safeGetHTTPParam_name();

      if( isset( $chapterid, $name ) ) $success = $chapters->setChapterName( $mediaid, $chapterid, $name );
      if( $success )
      {
        $result = $chapters->getChapterList( $mediaid, NULL );
      }
      else
      {
        $result = 'Error';
      }
      break;

    case 'del':
      $chapterid = safeGetHTTPParam_chapterid();
      if( isset( $chapterid ) ) $success = $chapters->delChapter( $mediaid, $chapterid );
      if( $success )
      {
        $result = $chapters->getChapterList( $mediaid, NULL );
      }
      else
      {
        $result = 'Error';
      }
      break;

    case 'sof':
      $chapterid = safeGetHTTPParam_chapterid();
      $offset = safeGetHTTPParam_offset();
      if( isset( $chapterid, $offset ) ) $success = $chapters->setChapterOffset( $mediaid, $chapterid, $offset );
      if( $success )
      {
        $result = $chapters->getChapterList( $mediaid, NULL );
      }
      else
      {
        $result = 'Error';
      }
      break;

    case 'mrk':
      $chapterid = safeGetHTTPParam_chapterid();
      if( isset( $chapterid ) ) $success = $chapters->postChapter( $mediaid, $chapterid );
      if( $success )
      {
        $result = $chapters->getChapterList( $mediaid, NULL );
      }
      else
      {
        $result = 'Error';
      }
      break;

    case 'umk':
      $chapterid = safeGetHTTPParam_chapterid();
      if( isset( $chapterid ) ) $success = $chapters->unpostChapter( $mediaid, $chapterid );
      if( $success )
      {
        $result = $chapters->getChapterList( $mediaid, NULL );
      }
      else
      {
        $result = 'Error';
      }
      break;

    default:
      $result = 'Unknown command';
      break;

  }

  if( isset( $result ) )
    sendResult( $result, false );
