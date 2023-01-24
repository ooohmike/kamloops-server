<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PFS Meeting Broadcaster - Live Agenda Editor</title>
<link rel="stylesheet" type="text/css" href="css/view.css" media="all">
<script language="javascript" type="text/javascript">
<!--
      var httpObject = null;
      var link = "";
      var timerID = 0;

      // Get the HTTP Object
      function getHTTPObject(){
         if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
         else if (window.XMLHttpRequest) return new XMLHttpRequest();
         else {
            alert("Your browser does not support AJAX.");
            return null;
         }
      } 

      function setOutput(){
         if(httpObject.readyState == 4){
            var response = httpObject.responseText;
            var objDiv = document.getElementById("result");
            objDiv.innerHTML = response;
            objDiv.scrollTop = objDiv.scrollHeight;
         }
      }

      function setAll(){
         if(httpObject.readyState == 4){
            var response = httpObject.responseText;
            var objDiv = document.getElementById("result");
            objDiv.innerHTML = response;
            objDiv.scrollTop = objDiv.scrollHeight;
         }
      }

      function doAddItem(){
         httpObject = getHTTPObject();
         if (httpObject != null) {
            link = "liveagenda_msg.php?mediaid=0&cmd=add&text="+encodeURIComponent(document.getElementById('newagendaitem').value);
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setOutput;
            httpObject.send(null);
            document.getElementById('newagendaitem').value = "";
         }
      }

      function doEdiItem(id,text){
         document.getElementById('newagendaitem').value = text;
         doDelItem(id);
      }

      function doDelItem(id){
         httpObject = getHTTPObject();
         if (httpObject != null) {
            link = "liveagenda_msg.php?mediaid=0&cmd=del&textid="+id;
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setOutput;
            httpObject.send(null);
         }
      }

      function doMarkItem(id){
         httpObject = getHTTPObject();
         if (httpObject != null) {
            link = "liveagenda_msg.php?mediaid=0&cmd=mrk&textid="+id;
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setOutput;
            httpObject.send(null);
         }
      }

      function doReload(){ 
         httpObject = getHTTPObject();
         if (httpObject != null) {
            link = "liveagenda_msg.php?mediaid=0&cmd=get";
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setOutput;
            httpObject.send(null);
         }
      }

      function UpdateTimer() {
         doReload(); 
         timerID = setTimeout("UpdateTimer()", 5000);
      }
 
    //-->
    </script> 
</head>
<body class="firefox" id="main_body" onload="UpdateTimer();">
  <img id="top" src="images/top.png" alt="">
  <div id="div_container">
    <h1><a>Live Agenda Editor</a></h1>
    <div class="appnitro">
      <div class="div_description">
        <h2>Live Agenda Editor</h2>
        <p>Add/Delete Agenda Items for a Live Meeting Broadcast</p>
        <p>Click "Mark" during a live broadcast to timestamp the agenda item and broadcast to the viewers</p>
      </div>
      <ul>
        <div id="result" ></div>
        <li id="li_4">
          <label class="description" for="element_4">Enter New Agenda Item</label>
          <div>
            <textarea id="newagendaitem" name="newagendaitem" class="element textarea small"></textarea>
          </div>
          <p class="guidelines" id="guide_4"><small>Copy and Paste the agenda item into the box the click on the Add Item button</small></p>
        </li>
        <li class="buttons">
          <button class="button_text" onclick="doAddItem();" >Add Item</button> 
        </li>
      </ul>
    </div>
    <div id="footer">
      <a href="http://www.playfullscreen.com/" >PlayFullScreen Internet Broadcasting Ltd.</a>
    </div>
  </div>
  <img id="bottom" src="images/bottom.png" alt="">
</body>
</html>
