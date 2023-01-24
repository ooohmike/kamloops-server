<!DOCTYPE HTML>
<html>
<head>
<title>City of Langley | <?php echo $pagename; ?></title>
<meta name="description" content="City of Langley">
<meta name="keywords" content="City of Langley, City Hall">
<meta name="robots" content="index,follow">
<meta name="distribution" content="global">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" >
<!--
  var agenda_list_head = "<table><tbody>";
  var agenda_list_item = "<tr><td class=\"agendaitem_cell\"><div class=\"agendaitem_entry\" id=\"agendaitem_%%id%%\"><a href=\"#\" onclick=\"%%click%%\" ><img src=\"images/play.gif\" alt=\"Play Video\" width=\"24\" height=\"17\">&nbsp;%%name%%</a></div></td></tr>";
  var agenda_list_tail = "</tbody></table>";

-->
</script>
<?php echo $html_jscript; ?>
</head>
<body>
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
                          <tr><td class="blue"><h3>City of Langley | <a href="."><?php echo $pagename; ?></a></h3></td><td class="alignright" style="padding-right:1px"><?php if( isset( $mediaid ) ) echo "<a href=\".\">main menu</a>"; ?></td></tr>
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
