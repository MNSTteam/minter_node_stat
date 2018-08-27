<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: NCZ');
header('Access-Control-Max-Age: 1728000');
header('Access-Control-Allow-Credentials: true');
header("X-Accel-Expires: 0");
header('Content-Type: text/html');

if(isset($_GET['pk'])) {

$CND = json_decode(file_get_contents("http://monsternode.net/api.php?candidate=".$_GET['pk']));
/*echo '<pre>';
print_r($CND);
echo '</pre>';*/
function trimzero($i) {
	return($i/1000000000000000000);
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
<div class="info3">
        <div class="infopad">
        <div class="inbl" style="min-height:217px">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
                    <tr>
                        <td>Node Rang</td>
                        <td style="text-align:right">#<?=$CND->data->validatorInfo->rank?></td>
                    </tr>
                    <tr>
                        <td>Node name</td>
                        <td style="text-align:right">unknown</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td style="color:<?=($CND->data->validatorInfo->status=='Candidate'?'#000':'#000')?>; text-align:right"><?=$CND->data->validatorInfo->status?></td>
                    </tr>
                    <tr>
                        <td>Uptime</td>
                        <td style="text-align:right"><?=substr($CND->data->validatorInfo->uptime,0,4)?>%</td>
                    </tr>
                    <tr>
                        <td>Commission</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->data->validatorInfo->commission?>%</td>
                    </tr>
                    <tr>
                        <td>Created at block</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->data->candidate->createAtBlock?></td>
                    </tr>
                    <tr>
                        <td>Actual block</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->status->latestBlockHeight?></td>
                    </tr>
                    <tr>
                        <td>Total stake</td>
                        <td class="xcolBlue" style="text-align:right" nowrap="nowrap"><?=number_format(trimzero($CND->data->validatorInfo->totalStake),0,'.',' ')?> <?=$CND->baseCoin?></td>
                    </tr>
                    <tr>
                        <td>Blockchain share</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->data->validatorInfo->networkPie?>%</td>
                    </tr>
                    
                    <tr>
                        <td nowrap="nowrap">Number of delegators</td>
                        <td class="xcolBlue" style="text-align:right"><?=$CND->data->candidate->delegants?></td>
                    </tr>
                    
                </table>
        </div>
        </div>
        </div>
        
        <div class="info2">
        <div class="infopad">
        <div class="inbl" style="min-height:217px">
        	<div class="ccHD" style="margin-bottom:0">Total stake and Reward dinamic</div>
        	<canvas id="myChart" height="90"></canvas>
        	
        	<?php
        	
        				$STAKE=array();
        				if(isset($CND->data->candidate->CREATE->data->stake)) {
                			$st=trimzero($CND->data->candidate->CREATE->data->stake);
                		} else if($CND->data->CREATE->data->stake) {
                			$st=trimzero($CND->data->CREATE->data->stake);
                		} else {
                			$st=0;
                		}
                		
                		
                		$arrt=(array)$CND->data->transactions;
        				ksort($arrt);
        				$c=0;
        				foreach($arrt as $k=>$v) {
        					$AMNT=($v->bip_value);
        					
        					if(!isset($STAKE[date("d.m.y",$k)])) { $STAKE[date("d.m.y",$k)]=$st; }
        					if($v->type==7) {
        						$st+=$AMNT;
        					}
        					if($v->type==8) {
        						$st-=$AMNT;
        					}
        					
        					$STAKE[date("d.m.y",$k)]=$st;
        				}
                		
                		
        
                		
                		$laststake=0;
                		$START=strtotime("2018-08-22 00:00");
                		$REWRDS=array();
                		for($x=$START; $x<=strtotime(date("Y-m-d 00:00",time())); $x=$x+(24*60*60)) {
                			$DT=date("d.m.y",$x);
                			$DTS[]=$DT;
                			
                			if(!isset($STAKE[$DT])) { 
                				$STAKE[$DT]=$laststake;
                			} else {
                				$laststake=$STAKE[$DT];
                			}
                			if(isset($CND->data->REWARDS->{date("y-m-d",$x)})) { 
                				$REWRDS[$DT]=$CND->data->REWARDS->{date("y-m-d",$x)};
                				//error_log($REWRDS[$DT]);
                			} else {
                				$REWRDS[$DT]=0;
                			}
                		}
                		
                		
                		
                		$STAKE[date("d.m.y")]=trimzero($CND->data->validatorInfo->totalStake);	
                		                            		
        	
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
					label: 'Acc. reward',
					backgroundColor: '#cf5c2c',
					borderColor: '#cf5c2c',
					data: [
						<?
						foreach($DTS as $v) {
							echo round(trimzero($REWRDS[$v])).', ';
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
        </div>
        </div>
        <div class="clear">&nbsp;</div>
        
        <div class="info3">
        <div class="infopad">
        <div class="inbl">
        	<div class="ccHD">Masternode actions</div>
        	
        
        	
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
        	
        	<?
        	
        	$STATC=array("createCoin"=>"Create coin",
"declareCandidacy"=>"Candidacy",
"setCandidateOnData"=>"Candidate On",
"setCandidateOffData"=>"Candidate Off");
        	
        	$c=0;
        	//krsort($CND->candidate->data->nodeAction);
        	foreach($CND->data->candidate->nodeAction as $k=>$v) {
        		$c++;
        		?>
        			<tr>
                        <td><?=$STATC[$v->type]?></td>
                        <td style="text-align:left; color:#7e7e7e"><?=$v->block?></td>
                        <td style="text-align:right"><?=humanTiming ($k)?></td>
                    </tr>
        		<?php
        		if($c==12) { break; }
        	}
            ?>       
                </table>
        	
        </div>
        </div>
        </div>
        
        
        <div class="info3">
        <div class="infopad">
        <div class="inbl">
        	<div class="ccHD">Last Stake actions</div>
        	
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
        	
        	<?

        	$arrt=(array)$CND->data->transactions;
        	krsort($arrt);
        	$c=0;
        	foreach($arrt as $k=>$v) {
        		?>
        			<tr>
                        <td><?=humanTiming ($k)?></td>
                        <td class="<?=($v->type==8?'colRed':'colBlue')?>" style="text-align:right"><?=($v->type==8?'-':'+')?><?=number_format(trimzero($v->type==7?$v->stake:$v->value), 0, '.', ' ')?> <?=$v->coin?></td>
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


		<div class="info3">
        <div class="infopad">
        <div class="inbl">
        
        	<div style="background-color:#cf5c2c; color:#fff; text-align:right; padding-right:10px">Delegators stake</div>
        	
        	<div style="background-color:#cf5c2c; float:left; width:<?=floor($CND->data->validatorInfo->delegatorsStakePie)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; top:-21px; font-weight:bold; left:2%"><?=round($CND->data->validatorInfo->delegatorsStakePie)?>%</div></div>
        	
        	<div style="background-color:#646076; float:left; width:<?=floor($CND->data->validatorInfo->ownerStakePie)?>%; height:40px; position:relative"><div style="position:absolute; font-size:18px; color:#fff; bottom:-21px; font-weight:bold; right:2%"><?=round($CND->data->validatorInfo->ownerStakePie)?>%</div></div>
        	
        	<div style="background-color:#646076; color:#fff; text-align:left; padding-left:10px;">Node owners stake</div>
        	
        	
        	<div class="clear" style="padding-bottom:30px">&nbsp;</div>
        	<?php
        		$ELSEproc=0;
        		$Baseproc=0;
        		foreach($CND->data->candidate->coinspie as $k=>$v) {
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
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="infoStbl">
                    

        		<?php
        		foreach($CND->data->candidate->coinspie as $k=>$v) {
        			if($CND->baseCoin!=$k) {
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
        
<?php
}
?>