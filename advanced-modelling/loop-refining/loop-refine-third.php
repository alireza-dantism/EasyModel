<?php
include_once("../../config/config.php");
session_start();

$jobname    =   $_POST['jobname'];
$ModelerLicense = strtoupper($_POST['ModelerLicense']);

chdir('jobs/' . $jobname);

$output3=null;
$retval3=null;

putenv('KEY_MODELLER10v1=' . $modellerLicense);
exec("mod10.1 model_energies.py & " , $output3, $retval3);
?>



<script type="text/javascript">
                     
                   
                    
        var myVar = setInterval(checkLog, 4000);
                        
                        
        function checkLog() {    
            
            jQuery("#messages").load('jobs/<?php echo $jobname; ?>/model_energies.log?v='+Math.floor(Math.random() * 11234242342), 'update=true');
            
            jQuery("#messages").animate({ scrollTop: $('#messages').prop("scrollHeight")}, 1000);
            
            var log_data = jQuery('#messages').text()
            if (log_data.indexOf("Total CPU time [seconds]") >= 0) {
                
                
                clearInterval(myVar);
                
                jQuery('#loading_text').html("----------------- Finish -----------------");
                
                
                // similar behavior as clicking on a link
                window.location.href = "http://bioinf.modares.ac.ir/software/easymodel/advanced-modelling/loop-refining/jobs/"+<?php echo $jobname; ?>;
                
               
                
            }
            
        }
        
</script>
