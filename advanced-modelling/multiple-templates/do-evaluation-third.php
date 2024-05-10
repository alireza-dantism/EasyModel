<?php
include_once("../../config/config.php");
session_start();

$jobname    =   $_POST['jobname'];
$querySeq   =   $_POST['querySeq'];

$ModelerLicense = $_POST['ModelerLicense'];
putenv('KEY_MODELLER10v1=' . $ModelerLicense);

chdir('jobs/' . $jobname);

$model_mult_log = fopen("model_mult.log", "r");


if ($model_mult_log) {
    while (($line = fgets($model_mult_log)) !== false) {
        // process the line read.
        $model_mult_log_array[] = $line;
    }

    fclose($model_mult_log);
}


$ff = 0;
foreach($model_mult_log_array as $line) {

    if (trim($line) == "----------------------------------------") {
        $ff = 1;
    } 
    
    if($ff){
        $model_mult_log_array2[] = $line;
    }
}

// remove first element -----------------
array_shift($model_mult_log_array2);
array_pop($model_mult_log_array2);  
array_pop($model_mult_log_array2);  

foreach($model_mult_log_array2 as $line) {
    $model_mult_log_DOPE[] = trim(strstr($line, ' '));
}

$bestTemplateDOPE = min($model_mult_log_DOPE);
$bestTemplateDOPE = array_search(min($model_mult_log_DOPE), $model_mult_log_DOPE);

$bestTemplateName = $model_mult_log_array2[$bestTemplateDOPE];
$bestTemplateName = trim(substr($bestTemplateName, 0, strpos($bestTemplateName, " ")));



// ----------------------------------------

$output=null;
$retval=null;

exec('echo "Our modeling is in the -evaluate_model- step" | tee step.txt && ' .
     "mod10.1 evaluate_model.py $bestTemplateName > /dev/null & " , $output, $retval);



$buildOthersProfile = explode("#",$querySeq);
foreach($buildOthersProfile as $profile) {
    $pdbCode = explode("-", $profile);
    $pdbCodeFit = $pdbCode[0];
    exec('echo "Our modeling is in the -evaluate_template- step" | tee step.txt && ' .
        "mod10.1 evaluate_template.py $pdbCodeFit > /dev/null & " , $output, $retval);
        
}



?>
