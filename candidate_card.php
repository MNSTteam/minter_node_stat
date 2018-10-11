<?php
//exit();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: NCZ');
header('Access-Control-Max-Age: 1728000');
header('Access-Control-Allow-Credentials: true');
header("X-Accel-Expires: 0");
header('Content-Type: text/html');

if(isset($_GET['pk'])) {

$_GET['pk']=preg_replace("/[^0-9a-zA-Z]+/ism","",$_GET['pk']);

$CND = json_decode(file_get_contents("http://monsternode.net/uptime.php?candidate=".$_GET['pk']));
if(!isset($_GET['rang'])) { $_GET['rang']=$CND->candidate->rang; }
$_GET['rang']=preg_replace("/[^0-9a-zA-Z]+/ism","",$_GET['rang']);

function trimzero($i) {
	return($i/1000000000000000000);
}
function number_format_short($n, $precision = 1)
{
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else
        if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else
            if ($n < 900000000) {
                // 0.9m-850m
                $n_format = number_format($n / 1000000, $precision);
                $suffix = 'M';
            } else
                if ($n < 900000000000) {
                    // 0.9b-850b
                    $n_format = number_format($n / 1000000000, $precision);
                    $suffix = 'B';
                } else {
                    // 0.9t+
                    $n_format = number_format($n / 1000000000000, $precision);
                    $suffix = 'T';
                }
                // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
                // Intentionally does not affect partials, eg "1.50" -> "1.50"
                if ($precision > 0) {
                    $dotzero = '.' . str_repeat('0', $precision);
                    $n_format = str_replace($dotzero, '', $n_format);
                }

    return $n_format . $suffix;
}
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



?>
<div id="mmcontent"<?php if(isset($_GET['actions'])) { ?> style="display:none"<? } ?>>

		<div class="info3">
        <div class="infopad">
        <div class="inbl" style="min-height:217px">
        
        <?php 
			 if(!isset($CND->candidate->DESCRIPTION->title)) { $CND->candidate->DESCRIPTION->title="Minter node"; }
        ?>
        	<div class="ccHD" style="text-align: center;">#<?=htmlentities($_GET['rang'])?>&nbsp;&nbsp;&nbsp;<?=$CND->candidate->DESCRIPTION->title?></div>
        	
        	<div style="text-align:center; position:relative; font-size:0.9em" class="ccHD">
        	<div style="min-height:100px; min-width:100px;"><?php if($CND->candidate->DESCRIPTION->icon!='') { ?><img src="<?=$CND->candidate->DESCRIPTION->icon?>" style="max-height:100px; max-width:100px;"/><?php } ?></div>
        	
        	<div style="position:absolute; top:-10px; left:0px; padding:3px; text-align:center; border-right:1px #f0f0f0 solid; border-bottom:1px #f0f0f0 solid; width:50px; border-radius:6px" title="Number of delegators"><img src="/i/users.svg" width="20" style="max-height:20px;margin-bottom:5px"><br><?=$CND->candidate->delegants?></div>
        	
        	<div style="position:absolute; top:-10px; right:0px; padding:3px; text-align:center; border-left:1px #f0f0f0 solid; border-bottom:1px #f0f0f0 solid; width:50px; border-radius:6px" title="Blockchain share"><img src="/i/pie.svg" width="20" style="max-height:20px;margin-bottom:5px"><br><?=$CND->candidate->networkPie?>%</div>
        	
        	<div style="position:absolute; bottom:0px; left:0px; padding:3px; text-align:center; border-right:1px #f0f0f0 solid; border-top:1px #f0f0f0 solid; width:50px; border-radius:6px" title="Node commission"><img src="/i/comission.svg" width="20" style="max-height:20px;margin-bottom:5px"><br><?=$CND->candidate->commission?>%</div>
        	
        	<div style="position:absolute; bottom:0px; right:0px; padding:3px; text-align:center; border-left:1px #f0f0f0 solid; border-top:1px #f0f0f0 solid; width:50px; border-radius:6px" title="Node up-time"><img src="/i/uptime.svg" width="20" style="max-height:20px;margin-bottom:5px"><br><?=substr($CND->candidate->uptime,0,4)?>%</div>
        	
        	</div>
        	
        	<div style="height:165px; overflow:hide">
        	<?php if(isset($CND->candidate->DESCRIPTION->title)) { ?>
        	<p align="center"><a href="<?=$CND->candidate->DESCRIPTION->www?>" target="_blank" style="text-decoration:none; font-weight:bold; color:#cf5c2c"><?=$CND->candidate->DESCRIPTION->www?></a></p>
        	<p style="word-wrap: break-word"><?=nl2br($CND->candidate->DESCRIPTION->description)?></p>
			
			<?php
			}
			?>
			</div>




<div style="border-top:1px #f0f0f0 solid; padding-top:15px">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/card/rank.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Node Stake Rang</td>
                        <td style="text-align:right">#<?=$_GET['rang']?></td>
                    </tr>
                    </table>
                    
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/card/status.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Status</td>
                        <td style="color:<?=($CND->candidate->realtimeTextStatus=='Candidate'?'#000':'#000')?>; text-align:right" nowrap="nowrap"><?=$CND->candidate->realtimeTextStatus?></td>
                    </tr>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/uptime.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Uptime</td>
                        <td style="text-align:right"><?=substr($CND->candidate->uptime,0,4)?>%<?=($CND->candidate->absentTimes12k>0?' (-'.$CND->candidate->absentTimes12k.')':'')?></td>
                    </tr>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/comission.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Commission</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->candidate->commission?>%</td>
                    </tr>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/card/declare.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Created at block</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->candidate->createAtBlock?></td>
                    </tr>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/card/Actual.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Actual block</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->CURRENTBLOCK?></td>
                    </tr>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/card/TotalStake.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Total stake</td>
                        <td class="xcolBlue" style="text-align:right" nowrap="nowrap"><?=number_format(trimzero($CND->candidate->total_stake),0,'.',' ')?> <?=$CND->baseCoin?></td>
                    </tr>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl" style="border-bottom:1px #f0f0f0 solid">
                    <tr>
                        <td style="background: url(/i/pie.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Blockchain share</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->candidate->networkPie?>%</td>
                    </tr>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
                    <tr>
                        <td nowrap="nowrap" style="background: url(/i/users.svg) center left no-repeat; background-size: 16px; padding-left: 22px; padding-top:2px">Number of delegators</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->candidate->delegants?></td>
                    </tr>
                    
                </table>
</div>


        </div>
        </div>
        </div>
        
        <div class="info2">
        <div class="infopad">
        <div class="inbl" style="min-height:217px">
        	<div class="ccHD" style="margin-bottom:0">Total stake and rewards dynamic</div>
        	<canvas id="myChart" height="90"></canvas>
        	
        	<?php
        	
        				$STAKE=array();
        				if(isset($CND->STARTSTAKE)) {
                			$st=$CND->STARTSTAKE;
                		} else {
                			$st=0;
                		}
                		
                		
                		$arrt=$CND->candidate->stakeActions;
        				//ksort($arrt);
        				$c=0;
        				foreach($arrt as $k=>$v) {
        					$AMNT=($v->bip_value);
        					
        					if(!isset($STAKE[date("d.m.y",$v->tm)])) { $STAKE[date("d.m.y",$v->tm)]=$st; }
        					if($v->type==7) {
        						$st+=$AMNT;
        					}
        					if($v->type==8) {
        						$st-=$AMNT;
        					}
        					
        					$STAKE[date("d.m.y",$v->tm)]=$st;
        				}
                		
        
                		
                		
                		$rewst=0;
                		
                		
                		$laststake=0;
                		$START=strtotime("2018-09-17 00:00");
                		$REWRDS=array();
                		for($x=$START; $x<=strtotime(date("Y-m-d 00:00",time())); $x=$x+(24*60*60)) {
                			$DT=date("d.m.y",$x);
                			$DTS[]=$DT;
                			
                			if(!isset($STAKE[$DT])) { 
                				$STAKE[$DT]=$laststake;
                			} else {
                				$laststake=$STAKE[$DT];
                			}
                			if(isset($CND->candidate->REWARDS->{date("d.m.y",$x)})) { 
                				$rewst+=$CND->candidate->REWARDS->{date("d.m.y",$x)};
                			}
                				$REWRDS[$DT]=$rewst;
                		}
                		
                		
                		
                		$STAKE[date("d.m.y")]=trimzero($CND->candidate->total_stake);	
                		                            		
        	
        	?>
        	
        	
        	
        	
        	<script>
var config = {
			type: 'line',
			data: {
				labels: [
				
						<?
						foreach($DTS as $v) {
							echo '"'.$v.'", ';
						}
						?>
				
				],
				datasets: [{
					label: 'Stake total',
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
				},
				{
					label: 'Delegators reward',
					backgroundColor: '#cf5c2c',
					borderColor: '#cf5c2c',
					data: [
						<?
						foreach($DTS as $v) {
							echo round($REWRDS[$v]).', ';
						}
						?>
					],
					fill: false,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'Stake total'
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
							labelString: 'Stake total, <?=$CND->baseCoin?>'
						}
					}]
				}
			}
		};

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, config);</script>
        	        
        	
        </div>
        
                <div style="margin:5px 0; padding-top:7px; padding:5px; font-size:14px; cursor:pointer; position:relative; min-height:auto; background: url(/i/copy.svg) 99% center no-repeat; background-size: 18px 18px;" class="pkcopy inbl" data-clipboard-action="copy" data-clipboard-text="<?=$_GET['pk']?>"><?=$_GET['pk']?></div>
                
                <script>
                if(!clipboard3) {
                var clipboard3 = new ClipboardJS('.pkcopy');
  							clipboard3.on('success', function(e) {

								alert('Node Public Key copied!');
    							e.clearSelection();
							});
				}
                </script>

        </div>
        </div>
        <!--div class="clear">&nbsp;</div-->



        
        <div class="info3" style="margin-top:0px">
        <div class="infopad">
        <div class="inbl" id="NODE_actions" style="display:none; position:relative">
        	
        	<div style="position:absolute; top:-22px">
        	<div class="ccHD" style="float:right; font-weight:normal; color:#cf5c2c; text-decoration:underline; cursor:pointer; background-color:#f0f0f0; padding:0 7px; border-top-left-radius:5px; border-top-right-radius:5px; border:1px #f0f0f0 solid; border-bottom:none; margin-left:3px" onclick="$('#NODE_actions').fadeOut(100); $('#STAKE_actions').fadeIn(200);">Stake actions</div>
        	<div class="ccHD" style="float:left; font-weight:normal; padding:0 7px;  border-top-left-radius:5px; border-top-right-radius:5px; border:1px #f0f0f0 solid; border-bottom:none; background-color:#fff; margin-right:3px">Node actions</div>
        	</div>
        
        	
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
        	
        	<?        	
        	$c=0;
        	if(isset($CND->candidate->actions)) {
        		$nodeAct=$CND->candidate->actions;
        	
        	foreach($nodeAct as $k=>$v) {
        		$c++;
        		?>
        			<tr>
                        <td><?=$v[1]?></td>
                        <td style="text-align:left; color:#7e7e7e"><?=$k?></td>
                        <!--td style="text-align:right"><?=humanTiming ($k)?></td-->
                    </tr>
        		<?php
        		if($c==12) { break; }
        	}
        	}
            ?>   
            
            	<tr>
                	<td valign="top" nowrap="nowrap" colspan="2" style="text-align:center; padding-top:7px"><a href="javascript:void(0)" onclick="showActs('<?=$_GET['pk']?>')" style="color:#cf5c2c; text-decoration:underline;" id="allactslink">All actions</a></td>
                 </tr>
                     
                </table>
                
        </div>





        <div class="inbl" id="STAKE_actions" style="position:relative;">
        
        	<div style="position:absolute; top:-22px">
        	<div class="ccHD" style="float:right; font-weight:normal; padding:0 7px;  border-top-left-radius:5px; border-top-right-radius:5px; border:1px #f0f0f0 solid; background-color:#fff; border-bottom:none; margin-left:3px">Stake actions</div>
        	<div class="ccHD" style="float:left; font-weight:normal; color:#cf5c2c; text-decoration:underline; cursor:pointer; background-color:#f0f0f0; padding:0 7px; border-top-left-radius:5px; border-top-right-radius:5px; border:1px #f0f0f0 solid; border-bottom:none; margin-right:3px" onclick="$('#STAKE_actions').fadeOut(100); $('#NODE_actions').fadeIn(200);">Node actions</div>
        	</div>
        	
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
        	
        	<?

        	$arrt=(array)$CND->candidate->stakeActions;
        	krsort($arrt);
        	$c=0;
        	foreach($arrt as $k=>$v) {
        		?>
        			<tr>
                        <td valign="top" nowrap="nowrap"><?=humanTiming ($v->tm)?></td>
                        <td class="<?=($v->type==8?'colRed':'colBlue')?>" style="text-align:right"><?=($v->type==8?'-':'+')?><?=(trimzero($v->amount)>100000000?number_format(round($v->bip_value,5), 5, '.', ' ').' '.$CND->baseCoin.'/':number_format(trimzero($v->amount), 0, '.', ' ').' ')?><?=$v->coin?></td>
                    </tr>
        		<?
        		$c++;
        		if($c==12) { break; }
        	}
        	?>
        	
                 
                 
                </table>
                
        </div>
        </div>
        </div>


		<div class="info3" style="margin-top:0px">
        <div class="infopad">
        <div class="inbl">
        
        	<div style="background-color:#cf5c2c; color:#fff; text-align:right; padding-right:10px">Delegators stake</div>
        	
        	<div style="background-color:#cf5c2c; float:left; width:<?=floor($CND->candidate->delegatorsStakePie)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; top:-21px; font-weight:bold; left:2%"><?=round($CND->candidate->delegatorsStakePie)?>%</div></div>
        	
        	<div style="background-color:#646076; float:left; width:<?=floor($CND->candidate->ownerStakePie)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; bottom:-21px; font-weight:bold; right:2%"><?=round($CND->candidate->ownerStakePie)?>%</div></div>
        	
        	<div style="background-color:#646076; color:#fff; text-align:left; padding-left:10px;">Node owners stake</div>
        	
        	
        	<div class="clear" style="padding-bottom:10px">&nbsp;</div>
        	<?php
        		$ELSEproc=0;
        		$Baseproc=0;
        		foreach($CND->candidate->COINPIE as $k=>$v) {
        			if($CND->baseCoin!=$k) {
        				$ELSEproc+=$v->pie;
        			} else {
        				$Baseproc+=$v->pie;
        			}
        		}
        	?>
        	<div style="background-color:#6f91d4; color:#fff; text-align:right; padding-right:10px"><?=$CND->baseCoin?> in the stake</div>
        	
        	<div style="background-color:#6f91d4; float:left; width:<?=floor($Baseproc)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; font-weight:bold; color:#fff; top:-21px; left:2%"><?=round($Baseproc)?>%</div></div>
        	
        	<div style="background-color:#878d66; float:left; width:<?=floor($ELSEproc)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; bottom:-21px; font-weight:bold; right:2%"><?=round($ELSEproc)?>%</div></div>
        	
        	<div style="background-color:#878d66; color:#fff; text-align:left; padding-left:10px">Other coins in the stake</div>
        	
        	<div class="clear">&nbsp;</div>
        	<div style="padding-top:10px">
        		<div style="height:77px; overflow-y:hide;">
        		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
                    

        		<?php
        		$cn=0;
        		foreach($CND->candidate->COINPIE as $k=>$v) {
        			if($CND->baseCoin!=$k) {
        			$cn++;
        				?>
        				<tr>
                        <td><?=$k?></td>
                        <td style="text-align:right"><?=$v->pie?>%</td>
                    	</tr>
        				<?
        				if($cn==3) { break; }
        			}
        		}
        		?>
        				<tr>
                        <td valign="top" nowrap="nowrap" colspan="2" style="text-align:center; padding-top:7px"><a href="javascript:void(0)" onclick="showPie('<?=$_GET['pk']?>')" style="color:#cf5c2c; text-decoration:underline;">All coins</a></td>
                    	</tr>
        		</table>
        		</div>
        	</div>
        	
        	
        </div>
        </div>
        </div>
        
</div>


<div id="actions"<?php if(!isset($_GET['actions'])) { ?> style="display:none"<? } ?>>
<a href="javascript:void(0)" onclick="actsBack()" style="background-color:#cf5c2c; text-decoration:none; font-weight:bold; text-align:center; color:#fff; font-size:16px; display:block; padding:10px; border-radius:6px;">Back</a>
<div class="clear" style="padding-bottom:10px">&nbsp;</div>
<div class="clear" style="font-weight:bold; padding-bottom:10px; font-size:16px; text-align:center">Node actions<br>
<small style="color:#999; font-weight:normal">Validator_address: <?=$CND->candidate->PUBKEYHASH?></small></div>
			<?
			$actsIcn=array(
				"AbsentBlock"=>array('#ffbe9e','/i/card/AbsentBlock.svg'),
				"setCandidateOnData"=>array('#aeffa1','/i/card/on.svg'),
				"setCandidateOffData"=>array('#b2b2ff','/i/card/off.svg'),
				"SlashEvent"=>array('#ffb2b2','/i/card/SlashEvent.svg'),
				"declareCandidacy"=>array('#b2fffc','/i/card/declare.svg')
			);
			
			        	
        	$c=0;
        	if(isset($CND->candidate->actions)) {
        		$nodeAct=$CND->candidate->actions;
        	
        	foreach($nodeAct as $k=>$v) {
        		$c++;
        		?>
        			<div style="padding:5px 0; margin:0 0 5px 5px; margin-right:0; float:left; border:1px #f0f0f0 solid; border-radius:6px; text-align:center; width:160px; background-color:<?=$actsIcn[$v[1]][0]?>">
                        <img src="<?=$actsIcn[$v[1]][1]?>" height="20px" /><br>
                        <strong><?=$v[1]?></strong>
                        <div style="color:#7e7e7e; font-size:12px"><a href="https://minter-node-1.testnet.minter.network:8841/api/block/<?=$k?>" target="_blank" style="color:#cf5c2c;"><?=$k?></a><?=($v[1]=="AbsentBlock"?'&nbsp;|&nbsp;<a href="https://minter-node-1.testnet.minter.network:8841/api/validators?height='.$k.'" target="_blank" style="color:#cf5c2c;">proof</a>':'')?></div>
                    </div>
        		<?php
        	}
        	}
            ?>
<div class="clear" style="padding-bottom:10px">&nbsp;</div>
<a href="javascript:void(0)" onclick="actsBack()" style="background-color:#cf5c2c; text-decoration:none; font-weight:bold; text-align:center; color:#fff; font-size:16px; display:block; padding:10px; border-radius:6px;">Back</a>
</div>  


<div id="piesAll" style="display:none;">
<!--a href="javascript:void(0)" onclick="actsBack()" style="background-color:#cf5c2c; text-decoration:none; font-weight:bold; text-align:center; color:#fff; font-size:16px; display:block; padding:10px; border-radius:6px;">Back</a>
<div class="clear" style="padding-bottom:10px">&nbsp;</div-->
<div align="center">
<div style="width:50%">
<div style="background-color:#cf5c2c; color:#fff; text-align:right; padding-right:10px">Delegators stake</div>
        	
        	<div style="background-color:#cf5c2c; float:left; width:<?=floor($CND->candidate->delegatorsStakePie)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; top:-21px; font-weight:bold; left:2%"><?=round($CND->candidate->delegatorsStakePie)?>%</div></div>
        	
        	<div style="background-color:#646076; float:left; width:<?=floor($CND->candidate->ownerStakePie)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; bottom:-21px; font-weight:bold; right:2%"><?=round($CND->candidate->ownerStakePie)?>%</div></div>
        	
        	<div style="background-color:#646076; color:#fff; text-align:left; padding-left:10px;">Node owners stake</div>
        	
        	
        	<div class="clear" style="padding-bottom:10px">&nbsp;</div>
        	<?php
        		$ELSEproc=0;
        		$Baseproc=0;
        		foreach($CND->candidate->COINPIE as $k=>$v) {
        			if($CND->baseCoin!=$k) {
        				$ELSEproc+=$v->pie;
        			} else {
        				$Baseproc+=$v->pie;
        			}
        		}
        	?>
        	<div style="background-color:#6f91d4; color:#fff; text-align:right; padding-right:10px"><?=$CND->baseCoin?> in the stake</div>
        	
        	<div style="background-color:#6f91d4; float:left; width:<?=floor($Baseproc)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; font-weight:bold; color:#fff; top:-21px; left:2%"><?=round($Baseproc)?>%</div></div>
        	
        	<div style="background-color:#878d66; float:left; width:<?=floor($ELSEproc)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; bottom:-21px; font-weight:bold; right:2%"><?=round($ELSEproc)?>%</div></div>
        	
        	<div style="background-color:#878d66; color:#fff; text-align:left; padding-left:10px">Other coins in the stake</div>
        	
        	<div class="clear">&nbsp;</div>
        	<div style="padding-top:10px">
        		<div>
        		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
                    

        		<?php
        		$cn=0;
        		foreach($CND->candidate->COINPIE as $k=>$v) {
        			if($CND->baseCoin!=$k) {
        			$cn++;
        				?>
        				<tr>
                        <td><?=$k?></td>
                        <td style="text-align:right"><?=$v->pie?>%</td>
                    	</tr>
        				<?
        			}
        		}
        		?>
        				
        		</table>
        		</div>
        	</div>
        	</div>
        	</div>
<div class="clear" style="padding-bottom:10px">&nbsp;</div>
<a href="javascript:void(0)" onclick="actsBack()" style="background-color:#cf5c2c; text-decoration:none; font-weight:bold; text-align:center; color:#fff; font-size:16px; display:block; padding:10px; border-radius:6px;">Back</a>
</div>       
        
        
<?php
}
?>