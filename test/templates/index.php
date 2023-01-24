<!DOCTYPE HTML>
<?php
include 'Mobile_Detect.php';
$detect = new Mobile_Detect();
$isMobile = $detect->isMobile();
?>

<html>
<head>
<title>Resort Municipality of Whistler | <?php echo $pagename; ?></title>
<meta name="description" content="Resort Municipality of Whistler">
<meta name="keywords" content=""Resort Municipality of Whistler, City Hall">
<meta name="robots" content="index,follow">
<meta name="distribution" content="global">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript" >

  var agenda_list_head = "<table id='agenda_list'><tbody>";
  var agenda_list_item = "<tr><td class=\"agendaitem_cell\"><div class=\"agendaitem_entry\" id=\"agendaitem_%%id%%\"><a id=\"%%agenda_index%%\" href=\"#\" onclick=\"%%click%%\" ><img src=\"images/play.gif\" alt=\"Play Video\" width=\"24\" height=\"17\">&nbsp;%%name%%</a></div></td></tr>";
  var agenda_list_tail = "</tbody></table>";


$(document).ready(function() {			
	setTimeout("$('#agenda_index_0').click()", 5000);			
});

<?php 
if ($isMobile && !isset( $mediaid )) {
?>
$(function() {
    $( "#dialog-message" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
  });
<?php } ?>

</script>
<?php echo $html_jscript; ?>
</head>
<body>
<?php	
	if ($isMobile && !isset( $mediaid )) {
?>
<div id="dialog-message" title="Mobile Device">
  <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 50px 0;"></span>
    We notice that you are on a mobile device. 
  </p>
  <p>
    Please be patience while the video loads.
  </p>
</div>
<?php } ?>

  <div class="container">
    <div class="box">
      <div class="border-top">
        <div class="border-right">
          <div class="border-bot">
            <div class="border-left">
              <div class="left-top-corner">
                <div class="right-top-corner">
                  <div class="right-bot-corner">
                    <div class="left-bot-corner">
                      <div class="inner">
                        <table class="alignleft">
                          <tr><td class="blue"><h3>Resort Municipality of Whistler | <a href="."><?php echo $pagename; ?></a></h3></td><td class="alignright" style="padding-right:1px"><?php if( isset( $mediaid ) ) echo "<a href=\".\">main menu</a>"; ?></td></tr>
                          <tr><td><?php echo $player; ?></td><td style="vertical-align: text-top"><div style="background : transparent; color : #000000; padding : 4px; width : 300px; height : 356px; overflow : auto; "><?php echo $html_playlist_code; ?></div></td></tr>
                          <tr><td><div id="CurrentAgendaItem"></div></td><td>&nbsp;</td></tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php include('templates/footer.php'); ?>
  </div>
</body>
</html>
