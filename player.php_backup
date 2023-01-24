<?php

require_once( 'db.php' );

function getPlayer( $mediaid, $zwidth, $zheight )
{
  $hlsurl = getHLSurl(    $mediaid );
  $flasrv = getFLASHsrvr( $mediaid );
  $flafil = getFLASHfile( $mediaid );
  $previewimg = getPreviewImg( $mediaid );

  if( 0 == $mediaid )
  {
    $jwplayer = <<<EOD1
<script type="text/javascript">
  var mediaid = $mediaid;
  var dataURL = "ajax_chapters.php";

  function init_player( edit )
  {
    window.jwplayer('videoplayer').setup(
    {
      autostart:true,
      bufferlength: "10",
      height:$zheight,
      width:$zwidth,
      image:'$previewimg',
      players:[
      {
        config:
        {
          file:'$flafil',
          streamer:'$flasrv'},
          type:'flash',
          src:'player/player.swf'
        },
        {
          config:
          {
            file:'$hlsurl'
          },
          type:'html5'
        }
      ],
      plugins:
      {
        'player/livestream.js':
        {}
      }
    });
    UpdateTimer();
  }
</script>
EOD1;
  }
  else
  {
    $jwplayer = <<<EOD2
<script type="text/javascript">
  var mediaid = $mediaid;
  var dataURL = "ajax_chapters.php";

  function init_player( edit )
  {
    window.jwplayer('videoplayer').setup(
    {
      autostart:true,
      flashplayer:'player/player.swf',
      height:$zheight,
      width:$zwidth,
      image:'$previewimg',
      file:'$hlsurl',
      provider:'http',
      'http.startparam':'starttime'
    });
    UpdateTimer();
    getAllAgenda( edit );
  }
</script>
EOD2;

  }

  return $jwplayer;
}

?>
