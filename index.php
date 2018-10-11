<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Minter Validators rating</title>

    <link data-n-head="true" rel="icon" type="image/x-icon" href="favicon.png">
    
<script src="jquery.min.js"></script>
<script src="winblur.js"></script>
<script src="clipboard/dist/clipboard.min.js"></script>
<script src="Chart.bundle.min.js"></script>
<script type="text/javascript" src="__jquery.tablesorter/jquery.tablesorter.js"></script>

<script>
/* FILL YOUR NODE PUBLIC KEY */
var myPKEY='';
</script>

<style type="text/css">
@font-face{
font-family:Ubuntu;
font-style:normal;
font-weight:400;
src:local("Ubuntu Regular"),
local("Ubuntu-Regular"),
url(fonts/ubuntu-v11-cyrillic_latin-regular.4f9cb44.woff2) format("woff2"),
url(fonts/ubuntu-v11-cyrillic_latin-regular.b3d1002.woff) format("woff")
}
@font-face{
font-family:Ubuntu;
font-style:normal;
font-weight:700;
src:local("Ubuntu Bold"),
local("Ubuntu-Bold"),
url(fonts/ubuntu-v11-cyrillic_latin-700.1878bde.woff2) format("woff2"),
url(fonts/ubuntu-v11-cyrillic_latin-700.0f3b6eb.woff) format("woff")}*,
:after,:before{box-sizing:border-box
}

body{background:#f6f6f6;color:#333;font-family:Ubuntu,SimSun,PingFang SC,sans-serif;font-size:14px;font-weight:400;height:100%;line-height:1.4;margin:0}
.clear {
	float:none;
	clear:both;
	width:100%;
	font-size:1px;
}
.head {
    background: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,.1);
    width: 100%;
}
.header__logo-image {
    font-size: 0;
    margin-left: 2px;
    margin-right: 20px;
    float: left;
}
.header__logo-text {
    font-size: 26px;
    line-height: 32px;
}
#rating tr th, #rating tr td, #AddrStakes tr th, #AddrStakes tr td {
	font-size: 15px;
	border-left:1px #e5e5e5 solid; 
}
#rating tr th, #AddrStakes tr th {
	padding-bottom: 10px;
	font-weight: bold;
	border-bottom:1px solid #e5e5e5;
	text-align: center;
}
#rating th.header, #AddrStakes th.header { 
    background-image: url(i/arrows.svg); 
    cursor: pointer; 
    font-weight: bold; 
    background-repeat: no-repeat; 
    background-position: 5px 7px; 
    padding-left: 17px;
} 
#rating th.headerSortUp, #AddrStakes th.headerSortUp { 
    background-image: url(i/arrow_up.svg); 
    color: #000; 
} 
#rating th.headerSortDown, #AddrStakes th.headerSortDown { 
    background-image: url(i/arrow_down.svg); 
    color: #000; 
} 
#rating tr th, #AddrStakes tr th {
	color: #666;
}
#rating tr td, #AddrStakes tr td {
	padding:10px 7px;
	text-align: center;
}
.nobrdl {
	border-left: none!important;
}
.even {
	background-color: #f0f0f0;
}
.odd {
	background-color: #fff;
}

.active {
	background-color: #cf5c2c!important;
	color:#fff;
	cursor: pointer;
}
.active td, .active td small {
	color:#fff!important;
}
.box_window{
  position:fixed;
  z-index:1199;
  background: #fff;
  display:none;
  padding:20px;
  -moz-border-radius: 10px; 
  border-radius: 10px; 
  	top: 50px;
    bottom: 50px;
    
    width:900px; /*Ширина блока*/
    margin:0 auto;
    left:50%;
    margin-left:-450px; /*Смещаем блок на половину всей ширины влево*/
    
    box-shadow: 0 2px 5px rgba(0,0,0,.7);
}
.box_window_in {
  overflow-y:auto;
  position:absolute;
  	top: 20px;
    right: 20px;
    bottom: 20px;
    left: 20px;
    margin: auto;
}
.box_title {
  position: absolute;
  left: 0px;
  top: -30px;
  left: 25px;
  color: #000;
  text-shadow: 1px 1px 1px #aeaeae!important;
  font-weight: bold;
  font-size: 18px;
  z-index: 9999;
  background: url(i/copy.svg) center right no-repeat;
  background-size: 18px 18px;
  padding-right: 25px;
  cursor: pointer;
}
.slash {
  background: url(i/card/SlashEvent.svg) center left no-repeat;
  background-size: 12px 12px;
  padding-left: 15px;
}
.block {
  background: url(i/card/AbsentBlock.svg) center left no-repeat;
  background-size: 12px 12px;
  padding-left: 15px;
}
.uptime {
  background: url(i/uptime.svg) center left no-repeat;
  background-size: 12px 12px;
  padding-left: 15px;
}
.bw_close{
  position:absolute;
  top: -25px;
  font-size: 10px;
  color: #fff;
  right:0px;
  cursor:pointer;
  z-index: 2;
}
.mask{
  position:fixed;
  background:rgba(0, 0, 0, 0.38);
  display:none;
  height:100%;
  width: 100%;
  z-index:10;
}
.to_blur.blur {
 -webkit-filter: blur(5px);
 -moz-filter: blur(5px);
 -o-filter: blur(5px);
 -ms-filter: blur(5px);
 filter: blur(5px);
}


.info3 {
	width: 33.3%;
	float: left;
}
.info2 {
	width: 66.6%;
	float: left;
}
.infopad {
	padding-right: 30px;
	padding-bottom: 30px;
}
.infopad div.inbl {
	border: 1px #f0f0f0 solid;
	padding: 10px;
	min-height: 280px;
	border-radius:6px;
}
.ccHD {
	font-size:16px; text-align:center; padding-bottom:10px; font-weight:bold;
	border-bottom: 1px #f0f0f0 solid;
	margin-bottom: 10px;
}
.colBlue {
	color:#6f91d4!important;
}
.colRed {
	color:#cf5c2c!important;
}
.wy-tooltip {
	border: 1px solid #f0f0f0;
	color: #444;
	background: #FFF;
	box-shadow: 0 2px 3px #999;
	position: absolute;
	padding: 5px;
	text-align: left;
	border-radius: 5px;
	 -moz-border-radius: 5px;
	 -webkit-border-radius: 5px;
	 font-size: 11px;
	 z-index: 999999;
}
.wy-hide { display: none; }

.candhide {
	display: none;
}
.button {
    align-items: center;
    border: 2px solid transparent;
    display: inline-flex;
    font-size: 14px;
    font-weight: 400;
    justify-content: center;
    padding: 5px 10px;
    position: relative;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    outline: 0;
    text-transform: none;
    background: #d15c22;
    color: #fff;
}
#checkaddr {
	font-size: 14px;
    font-weight: 400;
    padding: 5px 3px;
}
</style>
</head>

<body>
<div class="to_blur">
<div class="head">
	<div style="width:100%" align="center">
		<div style="width:1000px; padding:20px 0; text-align:left">
			<img alt="Minter" class="header__logo-image" height="36" src="i/minter-logo-circle.svg" width="36">
			<div class="header__logo-text" style="position:relative">
				Node explorer
				<div style="margin-left:50px; color:#666; font-size:11px; position:absolute; top:3px; left:210px">Last sync block:&nbsp;<span id="lastblock"></span></div>
				
				<div style="color:#999; font-size:14px; position:absolute; top:3px; right:0px">
					<form method="get" onsubmit="checkAddr(); return false"><input name="checkaddr" id="checkaddr" placeholder="Address Mx..." type="text" style="font-size: 14px; width:375px; border-radius:3px; border:1px #f0f0f0 solid" />&nbsp;&nbsp;&nbsp;<button class="button" type="submit" style="border-radius:3px">CHECK PROFIT</button></form>
				</div>
				
			</div>
		</div>
	</div>
</div>

<div style="width:100%" align="center">
<div style="width:1000px; text-align:left; background-color:#FFF; margin-top:20px">
<div style="padding:10px 10px">
<table width="100%" border="0" cellpadding="3" cellspacing="0" id="rating">
	<thead>
	<tr>
	<th nowrap="nowrap" class="nobrdl">Rang</th>
	<th nowrap="nowrap" align="left" style="text-align:left; padding-left:33px; background-position: 12px 7px;">Node</th>
	<th nowrap="nowrap">Comission</th>
	<th nowrap="nowrap" class="{sorter: 'integer'}" style="text-align:left; padding-left:30px; background-position: 15px 7px;">Total Stake (d24)</th>
	<th nowrap="nowrap">Node status</th>
	<th nowrap="nowrap">Delegators (d24)</th>
	<th nowrap="nowrap">Uptime</th>
	<th nowrap="nowrap">Age</th>
	</tr>
	</thead>
	
	
	<tbody>
	
	</tbody>
</table>


<div align="center" style="text-align:center" id="loader"><img src="i/loaderB.svg" /></div>


<div style="font-size:12px; color:#666; padding:30px 10px">

<h3 style="cursor:pointer; display:flex; border-bottom:1px #666 dashed; float:left" onclick="$('#howto').fadeIn('slow')">Как привязать логотип для Вашей ноды?</h3>
<div class="clear">&nbsp;</div>
<div id="howto" style="display:none">
Отправьте любую транзакцию на адрес<br>
<code>Mxa62da2d2714f23738a4d1658909eb6c920669b0e</code>
<br><br>
Поле "Message" заполните в следующем формате:
<br><br>
<code>{"PK":"PUBLIC KEY", "title":"NODE TITLE","www":"http://URL", "icon":"http://ICON_URL.svg", "description":"NODE_DESCRIPTION"}</code>
<br><br>
Транзакция должна быть отправлена с адреса владельца ноды.<br>
Чтобы поменять данные, достаточно отправить новую транзакцию в таком же формате и с нужными изменениями.<br>
Обновление данных - раз в 10 минут.
</div>


</div>

</div>
</div>
</div>

</div>

<a href="javascript:void(0)" id="copyAl" class="popbutton" data-window="copyAlert" style="display:none">&nbsp;</a>
<a href="javascript:void(0)" id="loaderL" class="popbutton" data-window="loaderD" style="display:none">&nbsp;</a>
<a href="javascript:void(0)" id="showCard" class="popbutton" data-window="validatorCard" style="display:none">&nbsp;</a>

<div style="display:none" id="copy_text"></div>

<div id="copyAlert" class="popwindow" data-title="Copied Public Key MonsterNode"><script>document.writeln(myPKEY)</script></div>

<div id="loaderD" class="popwindow" data-title="Loading..." style="background: url(i/loaderB.svg) center center no-repeat;">

</div>


<div id="validatorCard" class="popwindow" data-title="Node" style="overflow:show">
</div>



<script>
var openCard='N';


function addCommas(nStr, del)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + del + '$2');
    }
    return x1 + x2;
}

var timeparts = [
   {name: 'millenni', div: 31556736000, p: 'a', s: 'um'},
   {name: 'centur', div: 3155673600, p: 'ies', s: 'y'},
   {name: 'decade', div: 315567360},
   {name: 'y', div: 31556736},
   {name: 'm', div: 2629728},
   {name: 'd', div: 86400},
   {name: 'h', div: 3600},
   {name: 'm', div: 60},
   {name: 's', div: 1}
];

function timeAgoNaive2(comparisonDate) {
	var ttm=comparisonDate.getTime();
   var i = 0,
      parts = [],
      interval = Math.floor((new Date().getTime() - ttm) / 1000);
      iinn=interval;
   for ( ; interval > 0; i += 1) {
      value = Math.floor(interval / timeparts[i].div);
      interval = interval - (value * timeparts[i].div);
      if (value) {
         parts.push(value + '' + timeparts[i].name +' '+ (value !== 1 ? timeparts[i].p || '' : timeparts[i].s || ''));
      }
   }
   if (parts.length === 0) { return 'now'; }
   var ret=[];
   //for (var x=0; x<parts.length; x++) {
   		if(iinn>=1) {
   			//console.log('min sec '+parts[x]);
   			ret=parts[0]+parts[1];
   		}
   		if(iinn>=60) {
   			//console.log('min sec '+parts[x]);
   			ret=parts[0]+parts[1];
   		}
   		if(iinn>=3600) {
   			//console.log('h min '+parts[x]);
   			ret=parts[0]+parts[1];
   		}
   		if(iinn>=86400) {
   			//console.log('d h '+parts[x]);
   			ret=parts[0]+parts[1];
   		}
   		if(iinn>=2629728) {
   			//console.log('m d '+parts[x]);
   			ret=parts[0]+parts[1];
   		}
   		if(iinn>=31556736) {
   			//console.log('Y d'+parts[x]);
   			ret=parts[0]+parts[1];
   		}
   		
   //}
   return ret;
}

function showLoadCard(el) {
	$('#loaderD').parent().fadeOut("slow");
	document.getElementById('showCard').click();
}

function checkAddr() {
var addr = $('#checkaddr').val();
	if(addr.indexOf('Mx')==-1) { alert('No address!'); return; } else {
	$('#loaderL').click();
	$.get("balances.php?address="+addr, function(data) { 
		$('#validatorCard').attr('data-title',addr);
		$('#validatorCard').html(data);
		$('#validatorCard').parent().find('.box_title')[0].innerHTML=addr;
		$('#validatorCard').siblings('.box_title').attr('data-clipboard-text',addr);
		//console.log(data);
		$('#copy_text').html(addr);
		showLoadCard($(this));
		
		var sorting = [[2,1], [3,1]]; 
			
            $("#AddrStakes").trigger("update"); 
            // sort on the first column 
            $("#AddrStakes").tablesorter(
            	{ 
        			textExtraction: function(node) { 
            		// extract data from markup and return it  
            		if(node.getAttribute('data-sort')) {
            			return node.getAttribute('data-sort'); 
            		} else {
            			return node.innerText;
            		}
        		},
            	widgets: ['zebra'] 
    		});
            $("#AddrStakes").trigger("sorton",[sorting]); 
            
            
            
	});
	}
}					  

<?php if(isset($_GET) && sizeof($_GET)>0) { 
$ADDRgetvar='';
foreach($_GET as $k=>$v) {
	if(substr($k, 0, 2)=='Mx') { 
		$ADDRgetvar=preg_replace("/[^0-9a-zA-Z]+/ism","",$k);
		break;
	}
}

if($ADDRgetvar!='') {
?> 
	$('#checkaddr').val('<?=$ADDRgetvar?>');
	setTimeout(function() {
		checkAddr()
	}, 100);
<?php } } ?>

	var isFull='N';
	var srtf=0;


$(document).ready(function() 
    { 
     
     function validators(tp) {
     if(!tp) { tp='load'; }
     
        $.getJSON("https://monsternode.net/uptime.php", function(data) { 
                      
          var items = [];
          var GLOBC=1;
          var cls='even';
   			 	$.each(data['data'], function( n, c ) {
   			 		//console.log(c);
   			 		var ord = (GLOBC/2);
   			 		if((''+ord).indexOf('.')==-1) { cls='even'; } else { cls='odd'; }
   			 		GLOBC++;
   			 		PKEY = c['pub_key'].substr(0, 7)+'...'+c['pub_key'].substr(-7);
   			 		if(c['pub_key']==myPKEY) {
   			 			PKEY = '<strong>'+PKEY+'</strong>';
   			 		}
   			 		
   			 		if(!c['EXISTTOP']) {
   			 			c['EXISTTOP']=1;
   			 		}   			 		
   			 		
   			 		uptime=c['uptime'];
   			 		uptime='<span class="uptime">'+(''+uptime).substr(0, 4)+'%</span>';
   			 		if(c['absentTimes12k']>0) {
   			 			
   			 			var slash='';
   			 			if(c['slashes_num']>0) {
   			 				slash='&nbsp;&nbsp;&nbsp;<span class="slash" title="Slash events">'+c['slashes_num']+'</span>';
   			 			}
   			 			
   			 			uptime=uptime+'<br><span class="block" title="Absent blocks">'+c['absentTimes12k']+'</span>'+slash;
   			 		}
   			 		
   			 		var EXISTTOP2=c['EXISTTOP'];
   			 		
   			 		if(c['EXISTTOP']==1) {
   			 			uptime='-';
   			 			c['uptime']=0;
   			 			EXISTTOP2=0;
   			 		}
   			 		STAKE = c['total_stake']/1000000000000000000;
   			 		c['total_stake']=addCommas(Math.round(STAKE),' ');
   			 		
   			 		//console.log(new Date(c['create_time']['tm']*1000));
   			 		
   			 		age=timeAgoNaive2(new Date(c['create_time']['tm']*1000));
   			 		
   			 		var INOUT = Math.round(c['stake24']);
   			 		if(INOUT>0) { INOUT='+'+INOUT; }	
   			 		
   			 		if(c['DESCRIPTION']['title']) {
   			 		if(!c['DESCRIPTION']['icon'] || c['DESCRIPTION']['icon']=='') { c['DESCRIPTION']['icon']='/i/minter-logo-circle.svg'; }
   			 			PKEY='<div style="align-items: center; display: flex; font-weight:bold"><img src="'+c['DESCRIPTION']['icon']+'" style="max-height:32px; max-width:32px; margin-right:9px"/>'+c['DESCRIPTION']['title']+'</div>';
   			 		}
   			 		
   			 		if(c['status']=='Online' && c['EXISTTOP']==1) {
   			 			c['realtimeTextStatus']='Сhallenger';
   			 			EXISTTOP2=1;
   			 		} 
   			 			  
   			 		if(c['EXISTTOP']==1 && isFull=='N') {
   			 			cls=cls+' candhide';
   			 		} 
   			 		
   			 		$('#lastblock').html(data['lastSyncBlock']+'&nbsp;|&nbsp;Current:&nbsp;'+data['CURRENTBLOCK']);		 		   			 		
   			 		   			 		
   			 		items.push( "<tr class='"+cls+" trShowCand'><td style='font-weight:bold; text-align:center'  class='nobrdl rang' data-sort='"+n+"'>"+n+"</td><td class='pubkey' data-sort='"+c['pub_key']+"' style='text-align:left'>"+PKEY+"</td><td style='font-weight:bold; text-align:center'>"+c['commission']+"%</td><td data-sort='"+STAKE+"'>"+c['total_stake']+" "+data['baseCoin']+(c['stake24']?" <small style='color:#7e7e7e'>("+INOUT+")</small>":'')+"</td><td"+(c['EXISTTOP']==1?(c['realtimeTextStatus']=='Сhallenger'?' style="color:#5c5c5c"':' style="color:#7e7e7e"'):'')+" data-sort='"+EXISTTOP2+"'>"+c['realtimeTextStatus']+"</td><td data-sort='"+c['delegants']+"'>"+c['delegants']+(c['newdelegants24']?" <small style='color:#7e7e7e'>(+"+Math.round(c['newdelegants24'])+")</small>":'')+"</td><td data-sort='"+c['uptime']+"' style='font-weight:bold; text-align:center'>"+uptime+"</td><td data-sort='"+c['create_time']['tm']+"'>"+age+"</td></tr>" );
   			 	});
  			
  			if(isFull=='N') {
  				items.push( "<tr style='background-color: #cf5c2c!important; color:#fff; cursor: pointer;'><td style='font-weight:bold; text-align:center; border-top:5px #fff solid' class='nobrdl' colspan='8' onclick=\"$('.candhide').fadeIn(); this.style.display='none'; isFull=1\">All Nodes</td></tr>");
  			}
  			
  		if(tp=="update") { 
			$("#rating tbody").empty();
			$("#rating").trigger("update");
		}		
			
			// set sorting column and direction, this will sort on the first and third column 
            var sorting = [[4,1], [0,0]]; 

			
			$("#rating tbody").append(items.join( " " ));
			$("#loader").hide();
			
			if(tp=="update") { 
			setTimeout(function() {
				$("#rating tbody").trigger("update"); 
            	$("#rating tbody").trigger("sorton",[sorting]);
            },200);
            }

			
			if(srtf==0) {	
			srtf++; 
            //console.log(items);
            // let the plugin know that we made a update 
            $("#rating").trigger("update"); 
            // sort on the first column 
            $("#rating").tablesorter(
            	{ 
        			textExtraction: function(node) { 
            		// extract data from markup and return it  
            		if(node.getAttribute('data-sort')) {
            			return node.getAttribute('data-sort'); 
            		} else {
            			return node.innerText;
            		}
        		},
            	widgets: ['zebra'] 
    		});
            $("#rating").trigger("sorton",[sorting]); 
            
            }
            
            setTimeout(function() {
			$("#coins").trigger("update"); 
            $("#coins").trigger("sorton",[sorting]);
            },200);
            
                    $("#rating tr").mouseenter(function() {
    					if($(this).parent().prop("tagName")!='THEAD' && $(this).parent().prop("tagName")!='thead') { 
    						//$(this).add('background-color','#d4916f'); 
    						$(this).addClass("active");
    					}
  					})
  					.mouseleave(function() {
    					if($(this).parent().prop("tagName")!='THEAD' && $(this).parent().prop("tagName")!='thead') {
    						//$(this).css('background-color','transparent');
    						$(this).removeClass("active");
    					}
  					});
  					
  					  $('.trShowCand').click(function() {
  							showNode(this);
					  });

        });
        
} // validators

validators();

function showNode(el,pkey) {
if(pkey) { 
	var PK = pkey; 
} else {
	var PK = $(el).find('.pubkey')[0].getAttribute('data-sort');
	var rang = $(el).find('.rang')[0].getAttribute('data-sort');
}
  						$('#loaderL').click();
  						$.get("candidate_card.php?pk="+PK<?php if(isset($_GET['actions'])) { ?>+"&actions"<? } ?>, function(data) { 
  							$('#validatorCard').attr('data-title',PK);
  							$('#validatorCard').html(data);
  							$('#validatorCard').parent().find('.box_title')[0].innerHTML=PK;
  							$('#validatorCard').siblings('.box_title').attr('data-clipboard-text',PK);
  							//console.log(data);
  							$('#copy_text').html(PK);
  							showLoadCard();
  						});
}

<?php if(isset($_GET) && sizeof($_GET)>0) { 
$PKgetvar='';
foreach($_GET as $k=>$v) {
	if(substr($k, 0, 2)=='Mp') { 
		$PKgetvar=preg_replace("/[^0-9a-zA-Z]+/ism","",$k);
		break;
	}
}

if($PKgetvar!='') {
?> 
	setTimeout(function() {
		showNode('','<?=$PKgetvar?>')
	}, 100);
<?php } } ?>


							
							var clipboard2 = new ClipboardJS('.box_title');
  							clipboard2.on('success', function(e) {

								alert('Copied!');
    							e.clearSelection();
							}); 
							
						    
     
     var clipboard = new ClipboardJS('.btn');

clipboard.on('success', function(e) {

	document.getElementById('copyAl').click();
	//alert('Node Public Key copied!');
    e.clearSelection();
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
});
   
   	setInterval(function() {
		validators('update');
	}, 70000);

     
        
    } 
); 

                function showActs() {
                	$('#mmcontent').fadeOut('fast');
                	$('#actions').fadeIn('slow');
                }
                function showPie() {
                	$('#mmcontent').fadeOut('fast');
                	$('#piesAll').fadeIn('slow');
                }
                function actsBack() {
                	$('#actions').fadeOut('fast');
                	$('#piesAll').fadeOut('fast');
                	$('#mmcontent').fadeIn('slow');
                }


</script>

</body>
</html>