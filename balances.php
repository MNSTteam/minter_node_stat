<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: NCZ');
header('Access-Control-Max-Age: 1728000');
header('Access-Control-Allow-Credentials: true');
header("X-Accel-Expires: 0");
header('Content-Type: text/html');


function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}

if(isset($_GET['address'])) {

$_GET['address']=preg_replace("/[^0-9a-zA-Z]+/ism","",$_GET['address']);

$CND = json_decode(file_get_contents("http://monsternode.net/uptime.php?address=".$_GET['address'])); 
     
?>        
<div id="mmcontent">
		<div class="info3" style="width:40%">
        <div class="infopad">
        <div class="inbl" style="min-height:auto">
        <div class="ccHD" style="text-align: center;">Delegators state</div>
        
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid; margin-bottom:15px">
			<tr>
				<td>Delegated stake</td>
				<td class="colBlue" style="text-align:right"><?=number_format($CND->total_delegated_stake,5,'.',' ')?> <?=$CND->baseCoin?></td>
			</tr>
			<tr>
				<td>Total reward</td>
				<td class="colBlue" style="text-align:right"><?=number_format($CND->total_reward,5,'.',' ')?> <?=$CND->baseCoin?></td>
			</tr>
        </table>
        
        <div class="ccHD" style="text-align: center;">Last delegated</div>
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
        <?php
        $ld=0;
        	foreach($CND->lastDelegated as $tm=>$s) {
        		foreach($s as $pk=>$sv) {
        		?>
                    <tr>
                        <td><?=humanTiming($tm)?></td>
                         <td class="<?=($sv->type==8?'colRed':'colBlue')?>" style="text-align:right"><?=($sv->type==8?'-':'+')?><?=number_format($sv->amount, 0, '.', ' ')?>&nbsp;<?=$sv->coin?></td>
                         <td style="padding-left:10px; width:1%"><?=($sv->node!='NO'?'<img src="'.$sv->node.'" style="max-heght:18px; max-width:18px"/>':'#'.$CND->stakes->{$pk}->rang)?></td>
                    </tr>
        		<?php
        		$ld++;
        		if($ld>7) { break; }
        		}
        		if($ld>7) { break; }
        	}
        ?>
        	<tr>
                	<td valign="top" nowrap="nowrap" colspan="2" style="text-align:center; padding-top:7px"><a href="javascript:void(0)" onclick="showActs()" style="color:#cf5c2c; text-decoration:underline;">All actions</a></td>
                 </tr>
        </table>
        
        </div>
        </div>
        </div>
        
        <div class="info3" style="width:60%">
        <div class="infopad">
        <div class="inbl" style="min-height:auto">
        <div class="ccHD" style="text-align: center;">Summary</div>
        
        <canvas id="myChart" height="178"></canvas>
        <?php
        	
        				
                		$st=0;
                		$STAKEs=array();
                		
                		foreach($CND->rewards24 as $rew) {
        				foreach($rew as $vn) {
        				foreach($vn as $v) {
        					$AMNT=($v->bip_value);
        					$vtm=strtotime($v->tm);
        					if(!isset($STAKEs[$vtm])) { $STAKEs[$vtm]=0; }
        					$STAKEs[$vtm]+=$AMNT;
        				}
        				}
        				}
                		
                		
                		$arrt=$STAKEs;
        				ksort($arrt);
        				$c=0;
        				$max=0;
        				$smax=0;
        				foreach($arrt as $tm=>$rew) {
        					$tm=date("d.m.y",$tm);
        					if(!isset($STAKE[$tm])) { $STAKE[$tm]=$st; }
        					
        						$st=$rew;
        					
        					$STAKE[$tm]=$st;
        					if($st>$max) {
        						$max=$st;
        					}
        				}
                		
        
                		
                		$rewst=0;
                		$SLASHES=array();
                		foreach($CND->slashes as $slash) {
        				foreach($slash as $vn) {
        				foreach($vn as $v) {
        					$AMNT=($v->bip_value);
        					$vtm=strtotime($v->tm);
        					if(!isset($SLASHES[date("d.m.y",$vtm)])) { $SLASHES[date("d.m.y",$vtm)]=$rewst; }
        					        					
        					$SLASHES[date("d.m.y",$vtm)]-=$AMNT;
        					if($AMNT>$smax) {
        						$smax=$AMNT;
        					}
        				}
        				}
        				}
                		
                		
                		$laststake=0;
                		$START=strtotime("2018-09-17 00:00");

                		for($x=$START; $x<=strtotime(date("Y-m-d 00:00",time())); $x=$x+(24*60*60)) {
                			$DT=date("d.m.y",$x);
                			$DTS[]=$DT;
                			
                			if(!isset($SLASHES[$DT])) { 
                				$SLASHES[$DT]=0;
                			}
                		}
                		                            		
        	?>
        	
        	
        	
        	
        	<script>
var config = {
			type: 'bar',
			data: {
				labels: [
				
						<?
						foreach($DTS as $v) {
							echo '"'.$v.'", ';
						}
						?>
				
				],
				datasets: [{
					label: 'Rewards',
					backgroundColor: '#6f91d4',
					borderColor: '#6f91d4',
					data: [
						<?
						foreach($DTS as $v) {
							echo round($STAKE[$v]).', ';
						}
						?>
					],
					fill: false,
					type: 'line'
				},
				{
					label: 'Slashes',
					backgroundColor: '#cf5c2c',
					borderColor: '#cf5c2c',
					data: [
						<?
						foreach($DTS as $v) {
							echo round($SLASHES[$v]).', ';
						}
						?>
					],
					fill: true,
					//yAxisID: 'second-y-axis'
				}]
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'Rewards'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Rewards, <?=$CND->baseCoin?>'
						}
					}/*,
					{
						id: 'second-y-axis',
                		position: 'right',
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Slashes, <?=$CND->baseCoin?>'
						},
						ticks: {
							<?php if($smax==0) { $smax=1; } ?>
                    		suggestedMax: <?=round($max/2)?>,
                		}
					}*/]
				}
			}
		};

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, config);</script>
        
        </div>
        </div>
        </div>
        
<div class="clear">&nbsp;</div>


<table width="100%" border="0" cellpadding="3" cellspacing="0" id="AddrStakes">
	<thead>
	<tr>
	<th nowrap="nowrap" class="nobrdl">Rang</th>
	<th nowrap="nowrap" align="left" style="text-align:left; padding-left:33px; background-position: 12px 7px;" width="30%">Node</th>
	<th nowrap="nowrap">Commission</th>
	<th nowrap="nowrap" class="{sorter: 'integer'}" style="text-align:left; padding-left:30px; background-position: 15px 7px;">My Stake</th>
	<th nowrap="nowrap" class="{sorter: 'integer'}" style="text-align:left; padding-left:30px; background-position: 15px 7px;">My Reward</th>
	<th nowrap="nowrap">Uptime</th>
	<th nowrap="nowrap">Graph</th>
	</tr>
	</thead>
	
	
	<tbody>

<?php
$GLOBC=1;
foreach ($CND->stakes as $pk=>$stk) {

	$ord = ($GLOBC/2);
	if(strstr($GLOBC, '.')) { $cls='even'; } else { $cls='odd'; }
   	$GLOBC++;
   	
	if(isset($stk->info->title)) {
		$TIT='<a href="'.$stk->info->www.'" target="_blank" style="text-decoration:none; align-items: center; display: flex; font-weight:bold; color:#cf5c2c"><img src="'.$stk->info->icon.'" style="max-height:32px; max-width:32px; margin-right:9px"/>'.$stk->info->title.'</a>';
	} else {
		$TIT='<div style="text-decoration:none; align-items: center; display: flex; font-weight:bold; color:#666; white-space: -moz-pre-wrap; /* Mozilla */
white-space: -hp-pre-wrap; /* HP printers */
white-space: -o-pre-wrap; /* Opera 7 */
white-space: -pre-wrap; /* Opera 4-6 */
white-space: pre-wrap; /* CSS 2.1 */
white-space: pre-line; /* CSS 3 (and 2.1 as well, actually) */
word-wrap: break-word; /* IE */
word-break: break-all; font-size:0.7em; width:100%">'.$pk.'</div>';
	}
	?>
	<tr class="<?=$cls?>">
		<td style='font-weight:bold; text-align:center'  class='nobrdl' data-sort='<?=$stk->rang?>'>#<?=$stk->rang?></td>
		<td><?=$TIT?></td>
		<td nowrap="nowrap" align="center"><?=$stk->commission?>%</td>
	<td nowrap="nowrap" data-sort="<?=$stk->total_delegated_stake?>"><?=number_format($stk->total_delegated_stake,5,'.',' ')?> <?=$CND->baseCoin?></td>
	<td nowrap="nowrap" data-sort="<?=$stk->total_reward?>"><?=number_format($stk->total_reward,5,'.',' ')?> <?=$CND->baseCoin?></td>
	<td nowrap="nowrap"><?php
			$uptime=$stk->uptime;
   			 		$uptime='<span class="uptime">'.substr($uptime,0, 4).'%</span>';
   			 		if($stk->absentTimes12k>0) {  			 			
   			 			$slash='';
   			 			if($stk->slashes_num>0) {
   			 				$slash='&nbsp;<span class="slash" title="Slash events">'.$stk->slashes_num.'</span>';
   			 			}
   			 			
   			 			$uptime=$uptime.'&nbsp;<span class="block" title="Absent blocks">'.$stk->absentTimes12k.'</span>'.$slash;
   			 		}
	
	echo $uptime;
	?></td>
	<?php  ?>
	<td nowrap="nowrap" align="right" valign="middle">
        <div style="position:relative">
        <img src="/i/graph.svg" style="max-height:24px; max-width:24px; cursor:pointer;" onclick="$('.graphc').hide('fast'); if($('#show_myChart<?=$pk?>').is(':visible')) { $('#show_myChart<?=$pk?>').fadeOut('slow'); } else { $('#show_myChart<?=$pk?>').fadeIn('slow'); }" />
        <div id="show_myChart<?=$pk?>" style="display:none; position:absolute; width:550px; height:185px; top:-175px; left:-545px; padding:15px; background-color:#fff; border:3px #cf5c2c solid; border-radius:6px; border-bottom-right-radius:0px; z-index:9999; box-shadow: 0 2px 5px rgba(0,0,0,.7);" class="graphc"><img src="/i/close.svg" style="max-height:16px; max-width:16px; cursor:pointer; right:7px; top:7px; position:absolute" onclick="$('.graphc').hide('fast');" /><canvas id="myChart<?=$pk?>" height="185" width="550"></canvas></div>
        <?php
        	
        				
                		$st=0;
                		$STAKEs=array();
                		$STAKE=array();
                		$DTS=array();
        				foreach($CND->rewards24->{$pk} as $vn) {
        				foreach($vn as $v) {
        					$vtm=strtotime($v->tm);
        					if(!isset($STAKEs[$vtm])) { $STAKEs[$vtm]=0; }
        					$STAKEs[$vtm]+=$v->bip_value;
        				}
        				}
                		
                		
                		$arrt=$STAKEs;
        				ksort($arrt);
        				$c=0;
        				$max=0;
        				$smax=0;
        				foreach($arrt as $tm=>$rew) {
        					$tm=date("d.m.y",$tm);
        					if(!isset($STAKE[$tm])) { $STAKE[$tm]=$st; }
        					
        						$st=$rew;
        					
        					$STAKE[$tm]=$st;
        					if($st>$max) {
        						$max=$st;
        					}
        				}
                		
        
                		
                		$rewst=0;
                		$SLASHES=array();
        				foreach($CND->slashes->{$pk} as $vn) {
        				foreach($vn as $v) {
        					$vtm=strtotime($v->tm);
        					if(!isset($SLASHES[date("d.m.y",$vtm)])) { $SLASHES[date("d.m.y",$vtm)]=$rewst; }
        					        					
        					$SLASHES[date("d.m.y",$vtm)]-=$v->bip_value;
        					if($v->bip_value>$smax) {
        						$smax=$v->bip_value;
        					}
        				}
        				}
                		
                		
                		$START=strtotime("2018-09-17 00:00");

                		for($x=$START; $x<=strtotime(date("Y-m-d 00:00",time())); $x=$x+(24*60*60)) {
                			$DT=date("d.m.y",$x);
                			$DTS[]=$DT;
                			
                			if(!isset($SLASHES[$DT])) { 
                				$SLASHES[$DT]=0;
                			}
                		}
                		                            		
        	?>
        	
        	
        	
        	
        	<script>
var config = {
			type: 'bar',
			data: {
				labels: [
				
						<?
						foreach($DTS as $v) {
							echo '"'.$v.'", ';
						}
						?>
				
				],
				datasets: [{
					label: 'Rewards',
					backgroundColor: '#6f91d4',
					borderColor: '#6f91d4',
					data: [
						<?
						foreach($DTS as $v) {
							echo round($STAKE[$v]).', ';
						}
						?>
					],
					fill: false,
					type: 'line'
				},
				{
					label: 'Slashes',
					backgroundColor: '#cf5c2c',
					borderColor: '#cf5c2c',
					data: [
						<?
						foreach($DTS as $v) {
							echo round($SLASHES[$v]).', ';
						}
						?>
					],
					fill: true,
					//yAxisID: 'second-y-axis'
				}]
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'Rewards'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Rewards, <?=$CND->baseCoin?>'
						}
					}/*,
					{
						id: 'second-y-axis',
                		position: 'right',
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Slashes, <?=$CND->baseCoin?>'
						},
						ticks: {
						<?php if($smax==0) { $smax=1; } ?>
                    		suggestedMax: <?=round(((100*$max)/$smax)/2)?>,
                		}
					}*/]
				}
			}
		};

var ctx = document.getElementById("myChart<?=$pk?>").getContext('2d');
var myChart = new Chart(ctx, config);</script>
        <!--div class="clear" style="border-top:1px #f0f0f0 solid; margin:7px 0">&nbsp;</div-->
    </div>    
</td>
<?php  ?>
</tr>
	<?
}
?>
	</tbody>
</table>


</div>

<div id="actions" style="display:none;">
<a href="javascript:void(0)" onclick="actsBack()" style="background-color:#cf5c2c; text-decoration:none; font-weight:bold; text-align:center; color:#fff; font-size:16px; display:block; padding:10px; border-radius:6px;">Back</a>
<div class="clear" style="padding-bottom:10px">&nbsp;</div>
<div class="clear" style="font-weight:bold; padding-bottom:10px; font-size:16px; text-align:center">Last delegated</div>
<div align="center">
<table width="50%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
			<?php
        $ld=0;
        	foreach($CND->lastDelegated as $tm=>$s) {
        		foreach($s as $pk=>$sv) {
        		?>
                    <tr>
                        <td><?=humanTiming($tm)?></td>
                         <td class="<?=($sv->type==8?'colRed':'colBlue')?>" style="text-align:right"><?=($sv->type==8?'-':'+')?><?=number_format($sv->amount, 0, '.', ' ')?>&nbsp;<?=$sv->coin?></td>
                         <td style="padding-left:10px; width:1%"><?=($sv->node!='NO'?'<img src="'.$sv->node.'" style="max-heght:18px; max-width:18px"/>':'#'.$CND->stakes->{$pk}->rang)?></td>
                    </tr>
        		<?php
        		$ld++;
        		//if($ld>12) { break; }
        		}
        		//if($ld>12) { break; }
        	}
        ?>
</table>
</div>
<div class="clear" style="padding-bottom:10px">&nbsp;</div>
<a href="javascript:void(0)" onclick="actsBack()" style="background-color:#cf5c2c; text-decoration:none; font-weight:bold; text-align:center; color:#fff; font-size:16px; display:block; padding:10px; border-radius:6px;">Back</a>
</div> 

<?php
}
?>