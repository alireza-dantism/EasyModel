<?php

        $jobname    =   $_POST['jobname'];
        $chain      =   $_POST['chain'];
	$modellerLicense	=	$_POST['modellerLicense'];

        // ------------------------------ STEP 2
    
	putenv('KEY_MODELLER10v1=' . $modellerLicense);
	
        $file = file('jobs/' . $jobname . "/model-single.log");
        for ($i = max(0, count($file)-2); $i < count($file); $i++) {
          $best_tempalte =  $file[$i];
          $i++;
        }
        
        exec('cp evaluate_model.py jobs/' . $jobname . '/evaluate_model.py && ' 
           . 'cp evaluate_template.py jobs/' . $jobname . ' >  /dev/null &');            
        
        chdir('jobs/' . $jobname);
        
        $output3=null; $retval3=null;
        exec('mod10.1 evaluate_template.py ' . $chain . '  && '
           . 'mod10.1 evaluate_model.py ' . $best_tempalte . ' ' . $chain . ' > /dev/null &', $output3, $retval3);

        
?>



<?php

exec('mv ' . $best_tempalte . ' Model.pdb');


$model = [];
$handle = fopen('Template'.$chain.'.profile', "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        
        
        if (trim(substr( $line, 0, 1 )) == "#" || empty(trim($line))) {
        //   break;
        
        } else {
            // array_filter(explode(" ",$line));
            
            $string1    = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($line));  
            
            $string2    = str_replace(" ",",",$string1);
            $arr = explode(",", $string2);
            $string2    = end($arr);

            
            $model[] =  (float)$string2;
            
            
        }
        
    }

    fclose($handle);
}
// *****************************




$template = [];
$handle = fopen('Model.profile', "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        
        if (trim(substr( $line, 0, 1 )) == "#" || empty(trim($line))) {
        //   break;
        
        } else {
            // array_filter(explode(" ",$line));
            
            $string1    = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($line));  
            
            $string2    = str_replace(" ",",",$string1);
            $arr = explode(",", $string2);
            $string2    = end($arr);
            
            $template[] =  (float)$string2;
            
            
        }
        
    }

    fclose($handle);
}

// --------------------------------------------------------------------------------------------



$oio    = 0;
$gaps   = [];
$handle = fopen('alignment.ali', "r");

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        
        if ($line == "\n" || trim(substr( $line, 0, 1 )) == ">" || trim(substr( $line, 0, 10 )) == "structureX") { } else { $gaps[] =  $line; }
        
        if (substr(trim($line), -1) == '*' && $oio == 0) 
            break;
            
    }

    fclose($handle);
}


/* -------- MODEL --------------------- */

$gaps_string    =   implode("",$gaps);
$gaps_string    =   str_replace(array("\n", "\r"), '', $gaps_string);
$gaps_string    =   rtrim($gaps_string, "*");

$array = str_split($gaps_string);

$char_index =   0;
$gap_array = array();
foreach ($array as $char) {
    if ($char == "-") {
        $gap_array[]    =   $char_index;
    }
    ++$char_index;
}



foreach ($gap_array as $item) {
    $inserted = array( 'null' );
    array_splice( $model, $item, 0, $inserted );
}


/* -------- ------ --------------------- */







/* -------- Template --------------------- */
$oio    = 0;
$gaps   = [];
$gaps_string = "";
$handle = fopen('alignment.ali', "r");

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        
        if ($line == "\n" || trim(substr( $line, 0, 1 )) == ">" || trim(substr( $line, 0, 10 )) == "structureX") { } else { $gaps[] =  $line; }
        
        if (substr(trim($line), -1) == '*' && $oio == 0) {
            //break;
            $oio = 1;
            $gaps = [];
        }
    }

    fclose($handle);
}

unset($gaps[0]);


$gaps_string    =   implode("",$gaps);
$gaps_string    =   str_replace(array("\n", "\r"), '', $gaps_string);
$gaps_string    =   rtrim($gaps_string, "*");


$array = str_split($gaps_string);

$char_index =   0;
$gap_array = array();
foreach ($array as $char) {
    if ($char == "-") {
        $gap_array[]    =   $char_index;
    }
    ++$char_index;
}



foreach ($gap_array as $item) {
    $inserted = array( 'null' );
    array_splice( $template, $item, 0, $inserted );
}

/* -------- -------- --------------------- */










$template_str   =   "[";
foreach ($template as $key => $value) {
    if ($key+1 == count($template)) {
        $template_str .= $value;
    } else {
        $template_str .= $value . ',';
    }
}
$template_str   .=   "]";




$model_str   =   "[";
foreach ($model as $key => $value) {
    
    if ($key+1 == count($model)) {
        $model_str .= $value;
    } else {
        $model_str .= $value . ',';
    }
}
$model_str   .=   "]";

// $template
// $model

// --------------------------------------------------------

?>


<div class="downloadchart"><a style="    background: #b70e0e;
    padding: 4px 33px;
    display: block;
    width: 400px;
    margin: 0 auto;
    max-width: 100%;
    border-radius: 5px;
    color: #FFF;" href="http://bioinf.modares.ac.ir/software/easymodel/basic-modelling/jobs/<?php echo $jobname; ?>/index.php" target="_blank">See All Generated Files Here</a></div>
   

<div class="downloadchart">You can export your chart by clicking on burger menu -> <i class="fa fa-bars"></i></div>
                
                
<div id="makeChartPlot"></div>
<!-- partial -->


<script>
var colors = ['#086708', '#f00'];
Highcharts.chart('makeChartPlot', {

    title: {
        text: 'Plot Profiles'
    },
    yAxis: {
        title: {
            text: 'DOPE per-residue score'
        }
    },
    colors:colors,
    
     series: [
         
         {
        name: 'Template',
        data: <?php echo $model_str; ?>
    }
    
    , {
        name: 'Model',
        data: <?php echo $template_str; ?>
    }
    
    ],
    
    chart: {
        type: 'line',
        zoomType: 'xy'
    },

    responsive: {
        rules: [{
            condition: {
                maxWidth: 650
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>
