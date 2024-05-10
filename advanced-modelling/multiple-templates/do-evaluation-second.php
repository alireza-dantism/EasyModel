<?php
include_once("../../config/config.php");
session_start();

$modelSeq   =   $_POST['modelSeq'];
$jobname    =   $_POST['jobname'];
$query      =   substr_replace(str_replace(" ",", ",$_POST['query']) ,"", -1);
//$query      =   str_replace("),",")-",$query);
//$query      =   str_replace("- (","-(",$query);
$ModelerLicense = strtoupper($_POST['ModelerLicense']);

chdir('jobs/' . $jobname);

$linuXGetSteps = fopen("step.txt", "w") or die("Unable to open file!");
fwrite($linuXGetSteps, "");
fclose($linuXGetSteps);    

  

$output3=null;
$retval3=null;

putenv('KEY_MODELLER10v1=' . $ModelerLicense);
exec(
    'echo "Our modeling is in the -salign- step" | tee step.txt && ' .
    "mod10.1 salign.py \"$query\" " , $output3, $retval3);

//print_r($retval3);
//print_r($output3);

echo "<br/>" . $query . "<br/>" . $jobname;


$seq        =   $modelSeq;
$makePIR    =   ">P1;Model";
$makePIR    .=  "\n";

$count_chains   =   substr_count($seq,">");

if ($count_chains == 1) {
    
    $seq        =   substr($seq, strpos($seq, "\n") + 1);;
    $makePIR    .=  "sequence:Model:::::::0.00: 0.00";
    $makePIR    .=  "\n";
    $makePIR    .=  $seq;
    $makePIR    .=  "*";
    
} else if ($count_chains > 1) {
    
    $fasta_to_array =   explode(">",$seq);
    
    foreach($fasta_to_array as $fasta) {
        
        if ((strpos($fasta, 'Chain ' . $chain) !== false) || ((strpos($fasta, $chain.',') !== false)) || ((strpos($fasta, $chain.'|') !== false))) {
            $fasta_chain    =   $fasta;
            
            $seq        =   substr($fasta_chain, strpos($fasta_chain, "\n") + 1);;
            $makePIR    .=  "sequence:Model:::::::0.00: 0.00";
            $makePIR    .=  "\n";
            $makePIR    .=  $seq;
            $makePIR    .=  "*";     
            
            $flag_error = 0;
        } 
        
    }
    
    if ($flag_error != 0) {
        $flag_error = 1;
        $error_message  =   "There is no chain with name " . $chain . " in fasta seq.";
    }
    
} else if ($count_chains == 0) {
    
    $makePIR    =   ">P1;Model";
    $makePIR    .=  "\n";
    $makePIR    .=  "sequence:Model:::::::0.00: 0.00";
    $makePIR    .=  "\n";
    $makePIR    .=  $seq;
    $makePIR    .=  "*";    
    
    $flag_error = 0;
}

$myfile = fopen("Model.ali", "w") or die("Unable to open file!");
fwrite($myfile, $makePIR);
fclose($myfile);    

exec('echo "Our modeling is in the -model_mult- step" | tee step.txt && ' .
    "mod10.1 align2d_mult.py && mod10.1 model_mult.py \"$query\" > /dev/null &" , $output3, $retval3);

?>



<script type="text/javascript">
                   
        var getSteps = setInterval(checkSteps, 2000);
        function checkSteps() {
            jQuery("#checkStepText").load('jobs/<?php echo $jobname; ?>/step.txt?v='+Math.floor(Math.random() * 11234242342), 'update=true');
        }                   
                   
                    
        var myVar = setInterval(checkLog, 4000);
                        
                        
        function checkLog() {    
            
            jQuery("#messages").load('jobs/<?php echo $jobname; ?>/align2d_mult.log?v='+Math.floor(Math.random() * 11234242342), 'update=true');
            
            jQuery("#messages").animate({ scrollTop: $('#messages').prop("scrollHeight")}, 1000);
            
            var log_data = jQuery('#messages').text()
            if (log_data.indexOf("Total CPU time [seconds]") >= 0) {
                
                
                clearInterval(myVar);
                
                jQuery('#messages').html("");
             
                jQuery.ajax({
                    type: 'POST',
                    cache: false,
                    data: (
                            {
                                jobname: <?php echo $jobname; ?>,
                                querySeq: '<?php echo $query; ?>',
				ModelerLicense: '<?php echo $ModelerLicense; ?>'
                            }),
                    url: 'do-evaluation-third.php',
                    dataType: 'html',
                    success: function(response){ // <--- (data) is in json format
                    
                        jQuery("#response3").html(response);
                        
/*                        jQuery("#loading_progress").addClass("displayNone"); */
                        
                        jQuery("#checkStepText").addClass("displayNone");
                        
                        jQuery("#messages").addClass("displayNone");
                        
                        clearInterval(getSteps);

window.setTimeout(function() {
                   window.location.replace("http://bioinf.modares.ac.ir/software/easymodel/advanced-modelling/multiple-templates/jobs/<?php echo $jobname; ?>/index.php");

}, 13000);

                        
         
                  }
                });                    
                
                
            }
            
        }
        
</script>
