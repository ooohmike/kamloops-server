var httpObject = null;
var httpObject2 = null;
var link = "";
var timerID = 0;

// Get the HTTP Object
function getHTTPObject()
{
  if( window.ActiveXObject )
    return new ActiveXObject("Microsoft.XMLHTTP");
  else if( window.XMLHttpRequest )
    return new XMLHttpRequest();
  else
  {
    alert("Your browser does not support AJAX.");
    return null;
  }
}

function getAgendaName( item )
{
  var agendaitem = eval( '(' + item + ')' );

  if( ( agendaitem == "Error" ) || ( agendaitem == "No Results" ) )
    return '&nbsp;';
  else
    return agendaitem[0].name;
}

function recvAgendaItem()
{
  if( httpObject.readyState == 4 )
  {
    var response = httpObject.responseText;
    var objDiv = document.getElementById("CurrentAgendaItem");
    objDiv.innerHTML = getAgendaName( response );
  }
}

function getAgendaItem( offset )
{
  httpObject = getHTTPObject();
  if( httpObject != null )
  {
    if( isNaN( offset ) )
      offset = 0;
    var link = dataURL + '?mediaid=' + mediaid + "&cmd=fnd&offset=" + offset;
    httpObject.open("POST", link , true);
    httpObject.onreadystatechange = recvAgendaItem;
    httpObject.send(null);
  }
}

function getAgendaList( list )
{
  var agenda = eval( '(' + list + ')' );
  var index;
  var count = agenda.length;

  if( ( agenda == "Error" ) || ( agenda == "No Results" ) )
    return '&nbsp;';

  var agendalist_html = agenda_list_head;

  for( index = 0; index < count; index++ )
  {
    var item = agenda[index];

    var onclickfunc = "gotoIndex(" + item.offset + ", '" + escape( item.name ) + "');";

    var item_html = agenda_list_item + "\n";

    item_html = item_html.replace( '%%id%%', item.id );
	item_html = item_html.replace( '%%agenda_index%%', 'agenda_index_' + index );
    item_html = item_html.replace( '%%click%%', onclickfunc );
    item_html = item_html.replace( '%%name%%', item.name );

    agendalist_html += item_html;
  }

  agendalist_html += agenda_list_tail;

  return agendalist_html;
}

function recvAllAgendaItem()
{
  if( httpObject2.readyState == 4 )
  {
    var response = httpObject2.responseText;
    var objDiv = document.getElementById("AgendaItemList");
    objDiv.innerHTML = getAgendaList( response );
  }
}

function getAllAgenda()
{
  httpObject2 = getHTTPObject();
  if( httpObject2 != null )
  {
    var link = dataURL + '?mediaid=' + mediaid + "&cmd=lst";
    httpObject2.open("POST", link , true);
    httpObject2.onreadystatechange = recvAllAgendaItem;
    httpObject2.send(null);
  }
}

function doReload()
{
  if( jwplayer != null )
  {
    var position = Math.floor( jwplayer().getPosition() );
    getAgendaItem( position );
  }
}

function UpdateTimer()
{
  doReload();
  timerID = setTimeout("UpdateTimer()", 1000);
}      

function gotoIndex( offset, name )
{
  if( jwplayer != null )
  {
    jwplayer().seek( offset );
    getAgendaItem( offset );
  }
}

