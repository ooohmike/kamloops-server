<?php

  require_once( 'db.php' );
  require_once( 'player.php' );

  if( isset( $_REQUEST['mediaid'] ) )
    $mediaid = $_REQUEST['mediaid'];
  else
    exit;

  $width = 640;
  $zwidth = 1 * $width;
  $height = 360;
  $zheight = 1 * $height;

  $noplayer = "<img src=\"images/kamloops_broadcast_network2.jpg\" width=\"$zwidth\" height=\"$zheight\">";

  $bodytag = "<body>\n";

  $player = "<div id=\"videoplayer\">$noplayer</div>";

  $html_jscript = '';

  if( isset( $mediaid ) )
  {
    $jwplayer = getPlayer( $mediaid, $zwidth, $zheight );

    $edit_mode = 0;
    if( isset( $_REQUEST['edit'] ) )
    {
      if( 1 == $_REQUEST['edit'] )
        $edit_mode = 1;
    }

    $player .= "<script type=\"text/javascript\">init_player( $edit_mode );</script>";

    $html_jscript = "<script src=\"player/jwplayer.js\"></script>\n";
    $html_jscript .= "<script src=\"agenda.js\"></script>\n";
    $html_jscript .= $jwplayer;
  }

  if( isset( $mediaid ) )
  {
    $mediainfo = getVideoInfo( $mediaid );

    $html_section_head = "<table>";
    $html_media_description = "<tr><td><table><tr><td class=\"blue\"><b>$mediainfo[name]</b></td></tr><tr><td>$mediainfo[description]</td></tr></table></td></tr>";
    $html_chapters = "<tr><td><div id=\"AgendaItemList\"></div></td></tr>\n";
    $html_section_footer = "</table>";
    $html_playlist_code = $html_section_head . $html_media_description . $html_chapters . $html_section_footer;
  }

  $pagename = "Agenda Items Editor";

  include( 'templates/index.php' );
?>
