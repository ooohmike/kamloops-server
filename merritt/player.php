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
      //bufferlength: "10",
      height: '$zheight',
      width: '$zwidth',
	  fallback: false,
      playlist: [
      	{
			image:'$previewimg',
        	sources: [
				{
				  file: '$flasrv/$flafil',
				  rtmp: {
					  bufferlength: "10"
				  }
				},
				{ 
					file:'$hlsurl'
				}
			]
		}
	  ]
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
      height: '$zheight',
      width: '$zwidth',
	  primary: 'flash',
	  image:'$previewimg',
	  file:'$hlsurl', 
      startparam: 'start'
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
