(function(a){var b=function(g,q,o){var s;var j;var c;var k;var m;var e;var n;function h(){l(q,{display:"block"});s=new Date().getTime()/1000;if(s>m){f()}else{var u=Math.floor((m-s)/3600);var v=Math.floor(((m-s)%3600)/60);var w=Math.floor((m-s)%60);e.innerHTML="Starting in "+u+" hours, "+v+" minutes, "+w+" seconds.";setTimeout(h,1000)}}function t(){s=new Date().getTime()/1000;if(s<j){r()}else{e.innerHTML="Event ended, thanks for watching.";l(q,{display:"block"})}}function d(){s=new Date().getTime()/1000;if(o.start){m=new Date(o.start*1000).getTime()/1000}else{m=0}if(o.end){j=new Date(o.end*1000).getTime()/1000}else{j=new Date().getTime()/1000+24*3600}n=document.createElement("div");q.appendChild(n);if(o.title){n.innerHTML=o.title}else{n.innerHTML="Live Event"}e=document.createElement("div");q.appendChild(e);if(s<m){h()}else{if(s>j){t()}else{f()}}g.onIdle(t)}g.onReady(d);function f(){l(q,{display:"none"});g.play()}function r(){if(!k){e.innerHTML="Attempting to (re)connect to stream.";l(q,{display:"block"});k=true;c=setInterval(p,500);setTimeout(i,10000)}}function p(){e.innerHTML+="."}function i(){clearInterval(c);k=false;f()}this.resize=function(v,u){if(String(v).indexOf("px")>0){u=Number(u.substr(0,u.length-2));v=Number(v.substr(0,v.length-2))}l(q,{backgroundImage:"url(data:image/png;base64,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)",backgroundRepeat:"no-repeat",backgroundPosition:"left center",height:u,textAlign:"left",width:v});l(n,{color:"#FFF",fontFamily:"Arial",fontSize:"26px",fontWeight:"bold",height:"30px",lineHeight:"30px",left:"119px",overflow:"hidden",position:"absolute",textAlign:"left",top:Math.round(u/2-30)+"px",width:(v-120)+"px"});l(e,{color:"#FFF",fontFamily:"Arial",fontSize:"13px",height:"20px",left:"120px",lineHeight:"20px",overflow:"hidden",position:"absolute",top:Math.round(u/2+4)+"px",width:(v-120)+"px"})};function l(u,v){for(var w in v){u.style[w]=v[w]}}};a().registerPlugin("livestream",b)})(jwplayer);