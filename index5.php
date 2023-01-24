<?php

  require_once( 'db.php' );
  require_once( 'player.php' );
  require_once( 'config.php' );

  if( isset( $_REQUEST['mediaid'] ) )
    $mediaid = $_REQUEST['mediaid'];

  $width = PFS_VIDEOWIDTH;
  $zwidth = 1 * $width;
  $height = PFS_VIDEOHEIGHT;
  $zheight = 1 * $height;
  $hlsurl = getHLSurl(    $mediaid );
  //$rtspurl = getRTSPurl( $mediaid );

  //if(isset($mediaid)){
	//	$noplayer = '<video src="' . $hlsurl . '" width="$width" height="$height" controls><img src="' . PFS_VIDEOIMAGE . '" width="$zwidth" height="$zheight"></video><p>Video not playing? <a href="' . $rtspurl . '">Try this link.</a></p>';
  //} else {
  		$noplayer = "<img src=\"" . PFS_VIDEOIMAGE . "\" width=\"$zwidth\" height=\"$zheight\">";
  //}
  

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
	//$html_jscript = "<script type=\"text/javascript\" src=\"http://jwpsrv.com/library/skzB3HQTEeO5oSIACrqE1A.js\"></script>\n";
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
  else
  {
    // show the list of all available movies for the customer
    $videolist = getVideoList( PFS_BROADCASTERID );

    $html_section_head = "";

    $html_video_list = "";
    foreach( $videolist as $video )
    {
      $html_video_list .= "<table style=\"border-bottom: .5px solid #cccccc; line-height: 1em;\"><tr><td rowspan=2><a href=\"".$video['url']."\"><img src=\"images/play.gif\" alt=\"Play Video\" width=\"24\" height=\"17\"></a>&nbsp;</td><td><a href=\"".$video['url']."\"><b>".$video['name']."</b></a></td></tr><tr class=\"alignleft\"><td>".$video['description']."</td></tr></table>";
    }

    $html_section_footer = "";

    $html_playlist_code = $html_section_head . $html_video_list . $html_section_footer;

  }

  $pagename = "Broadcast Network";

  include( './templates/index.php' );
?>
