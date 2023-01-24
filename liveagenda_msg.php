<?php

require_once( 'db_cfg.php' );
require_once( 'config.php' );

// disable caching, we want the users to update from the server every time
header( 'Expires: 0' );
header( 'Cache-Control: must-revalidate, proxy-revalidate, no-cache, no-store, max-age=0, s-maxage=0' );

$db = db_connect();
$broadcasterid = PFS_BROADCASTERID;

function delItem( $mediaid )
{
  global $db;
  global $broadcasterid;

  if( !isset( $mediaid ) )
    return;

  if( !isset( $_REQUEST['textid'] ) )
    return;

  $textid = htmlspecialchars( trim( $_REQUEST['textid'] ) );

  $textid_db = $db->quoteSmart( $textid );

  $sql = "UPDATE agenda_items SET deleted=1 WHERE id=$textid_db AND broadcasterid=$broadcasterid;";

  $result = $db->query( $sql );

  if( PEAR::isError( $result ) )
  {
    error_log( 'Chat::msg: ' . $result->GetMessage() );
  }

  return getAllItems( $mediaid );
}

function addItem( $mediaid )
{
  global $db;
  global $broadcasterid;

  if( !isset( $mediaid ) )
    return;

  if( !isset( $_REQUEST['text'] ) )
    return getAllItems( $mediaid );

  $text = trim( $_REQUEST['text'] );

  if( empty( $text ) )
    return getAllItems( $mediaid );

  $text = htmlspecialchars( $text );

  $text_db = $db->quoteSmart( $text );

  $sql = "INSERT INTO agenda_items SET mediaid=$mediaid, broadcasterid=$broadcasterid, name=$text_db;";

  $result = $db->query( $sql );
  if( PEAR::isError( $result ) )
  {
    error_log( 'Chat::msg: ' . $result->GetMessage() );
  }

  return getAllItems( $mediaid );
}

function mrkItem( $mediaid )
{
  global $db;
  global $broadcasterid;

  if( !isset( $mediaid ) )
    return;

  if( !isset( $_REQUEST['textid'] ) )
    return;

  $textid = htmlspecialchars( trim( $_REQUEST['textid'] ) );

  $textid_db = $db->quoteSmart( $textid );

  $sql = "UPDATE agenda_items SET posted=1, date=CURRENT_TIMESTAMP WHERE id=$textid_db AND broadcasterid=$broadcasterid;";

  $result = $db->query( $sql );

  if( PEAR::isError( $result ) )
  {
    error_log( 'Chat::msg: ' . $result->GetMessage() );
  }

  return getAllItems( $mediaid );
}

function ediItemMark( $mediaid )
{
  global $db;
  global $broadcasterid;

  if( !isset( $mediaid ) )
    return;

  if( !isset( $_REQUEST['textid'] ) )
    return;

  $textid = htmlspecialchars( trim( $_REQUEST['textid'] ) );

  $textid_db = $db->quoteSmart( $textid );

  if( !isset( $_REQUEST['offset'] ) )
    return;

  $offset = htmlspecialchars( trim( $_REQUEST['offset'] ) );

  $offset_db = $db->quoteSmart( $offset );

  $sql = "UPDATE agenda_items SET posted=1, offset=$offset_db, date=CURRENT_TIMESTAMP WHERE id=$textid_db AND broadcasterid=$broadcasterid;";

  $result = $db->query( $sql );

  if( PEAR::isError( $result ) )
  {
    error_log( 'Chat::msg: ' . $result->GetMessage() );
  }

  return getAllItems( $mediaid );
}

function ediItemMark2( $mediaid )
{
  global $db;
  global $broadcasterid;

  if( !isset( $mediaid ) )
    return;

  if( !isset( $_REQUEST['textid'] ) )
    return;

  $textid = htmlspecialchars( trim( $_REQUEST['textid'] ) );

  $textid_db = $db->quoteSmart( $textid );

  if( !isset( $_REQUEST['position'] ) )
    return;

  $offset = htmlspecialchars( trim( $_REQUEST['position'] ) );

  $offset_db = $db->quoteSmart( $offset );

  $sql = "UPDATE agenda_items SET posted=1, offset=$offset_db, date=CURRENT_TIMESTAMP WHERE id=$textid_db AND broadcasterid=$broadcasterid;";
error_log( $sql );

  $result = $db->query( $sql );

  if( PEAR::isError( $result ) )
  {
    error_log( 'Chat::msg: ' . $result->GetMessage() );
  }

}

function getPlyItems( $mediaid )
{
  global $db;
  global $broadcasterid;

  $mediaid_db = $db->quoteSmart( $mediaid );

  if( isset( $_REQUEST['position'] ) )
    $offset = $db->quoteSmart( $_REQUEST['position'] );
  else
    $offset = 9999999;

  $sql = "SELECT name FROM agenda_items WHERE mediaid=$mediaid_db AND broadcasterid=$broadcasterid AND posted AND NOT deleted AND offset <= $offset ORDER BY date DESC LIMIT 1;";

  $result = $db->getAll( $sql, array(), DB_FETCHMODE_ASSOC );
  if( PEAR::isError( $result ) )
  {
    error_log( "Chat::all: " . $result->GetMessage() );
    exit;
  }

  $allItems = '';

  foreach( $result as $item )
  {
    $allItems .= "<br><br><span class=\"txt\">$item[name]</span><br>\n";
  }

  return $allItems;
}

function getAllItems2( $mediaid )
{
  global $db;
  global $broadcasterid;

  $edit_mode = false;
  if( isset( $_REQUEST['edit'] ) )
    $edit_mode = true;

  $mediaid_db = $db->quoteSmart( $mediaid );

  $sql = "SELECT id, offset, name FROM agenda_items WHERE mediaid=$mediaid_db AND broadcasterid=$broadcasterid AND posted AND NOT deleted ORDER BY offset;";

  $result = $db->getAll( $sql, array(), DB_FETCHMODE_ASSOC );
  if( PEAR::isError( $result ) )
  {
    error_log( "Chat::all: " . $result->GetMessage() );
    exit;
  }

  $html_section_head = "<table>";

  $html_chapters = "";
  foreach( $result as $chapter )
  {
    $html_chapters .= "<tr>";
    $html_chapters .= "<td class=\"pfs_item\"><div id=\"agendalist_$chapter[id]\">";
    if( $edit_mode ) $html_chapters .= "<button onclick=\"markItem($chapter[id]);\" >Mark</button>";
    $html_chapters .= "<a href=\"#\" onclick=\"gotoIndex($chapter[offset], '$chapter[name]');\" ><img src=\"images/play.gif\" alt=\"Play Video\" width=\"24\" height=\"17\"></a>&nbsp;";
    $html_chapters .= "<a href=\"#\" onclick=\"gotoIndex($chapter[offset], '$chapter[name]');\" >$chapter[name]</a>";
    $html_chapters .= "</div></td>";
    $html_chapters .= "</tr>\n";

//    $html_chapters .= "<tr><td style=\"border-bottom: .5px solid #cccccc; line-height: 1em; padding-bottom:2px; \"><a href=\"".$chapter['url']."\" class=\"rollover\"></a><a href=\"".$chapter['url']."\" >".$chapter['name']."</a></td></tr>";

  }

  $html_section_footer = "</table>";

  $html_allitems = '<table>' . $html_chapters . '</table>';

  return $html_allitems;
}


function getAllItems( $mediaid )
{
  global $db;
  global $broadcasterid;

  $mediaid_db = $db->quoteSmart( $mediaid );

  $sql = '';
  $sql .= "( SELECT id, name, posted FROM agenda_items WHERE mediaid=$mediaid AND broadcasterid=$broadcasterid AND posted AND NOT deleted ORDER BY date DESC )";
  $sql .= " UNION ";
  $sql .= "( SELECT id, name, posted FROM agenda_items WHERE mediaid=$mediaid AND broadcasterid=$broadcasterid AND NOT posted AND NOT deleted ORDER BY id )";
  $sql .= ";";

  $result = $db->getAll( $sql, array(), DB_FETCHMODE_ASSOC );
  if( PEAR::isError( $result ) )
  {
    error_log( "Chat::all: " . $result->GetMessage() );
    exit;
  }

  $allItems = '';

  foreach( $result as $item )
  {
    $item_html = "<li class=\"section_break\"><h3><div id=\"agendaitem_$item[id]\" >$item[name]</div></h3>";
    if( !$item['posted'] )
      $item_html .= "<button onclick=\"doMarkItem($item[id]);\" >Mark</button>&nbsp;<button onclick=\"doEdiItem($item[id],'$item[name]');\" >Edit</button>&nbsp;<button onclick=\"doDelItem($item[id]);\" >Delete</button>";
    $item_html .= "<p></p></li>";

    $allItems .= $item_html . "\n";
  }

  return $allItems;
}

$mediaid = 0;
if( isset( $_REQUEST['mediaid'] ) )
{
  $mediaid = $_REQUEST['mediaid'];
}

if( isset( $_REQUEST['cmd'] ) )
{
  switch( $_REQUEST['cmd'] )
  {
    case 'add':
      $result = addItem( $mediaid );
      break;
    case 'del':
      $result = delItem( $mediaid );
      break;
    case 'mrk':
      $result = mrkItem( $mediaid );
      break;
    case 'mk2':
      $result = ediItemMark( $mediaid );
      break;
    case 'get':
      $result = getAllItems( $mediaid );
      break;
    case 'ply':
      $result = getPlyItems( $mediaid );
      break;
    case 'pre':
      break;
    case 'lst':
      $result = getAllItems2( $mediaid );
      break;
    case 'mk3':
      $result = ediItemMark2( $mediaid );
      break;
  }

  if( isset( $result ) )
    echo $result;
}

?>
