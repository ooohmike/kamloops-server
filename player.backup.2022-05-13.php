<?php

require_once( 'db.php' );

function getPlayer( $mediaid, $zwidth, $zheight )
{
  $hlsurl = getHLSurl(    $mediaid );
  $flasrv = getFLASHsrvr( $mediaid );
  $flafil = getFLASHfile( $mediaid );
  $flaurl = $flasrv . "/" .  $flafil;
  $previewimg = getPreviewImg( $mediaid );

  if( 0 == $mediaid )
  {
    $jwplayer = <<<EOD1
<script type="text/javascript">
  var mediaid = $mediaid;
  var dataURL = "ajax_chapters.php";

  function init_player( edit )
  {
    jwplayer('videoplayer').setup(
    {
      autostart:true,
      androidhls: true,
      height:$zheight,
      width:$zwidth,
      image:'$previewimg',
      playlist:[
      	{
       		sources: [
       			{
       			       file:'$flaurl',
          		},
          		{
          				file: '$hlsurl'
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
   jwplayer('videoplayer').setup(
    {
      autostart:true,
      androidhls: true,     
      height:$zheight,
      width:$zwidth,
      image:'$previewimg',
      playlist: [
      	{
      		sources: [
      			{
      				file: '$hlsurl'
      			}
      		]
      	}
      ],
      startparam: 'starttime'
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
