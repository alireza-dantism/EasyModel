<?php
include_once("../../config/config.php");
session_start();

$jobname    =   $_POST['jobname'];
$query      =   $_POST['query'];
$ModelerLicense	=	strtoupper($_POST['ModelerLicense']);

chdir('jobs/' . $jobname);

$output3=null;
$retval3=null;


putenv('KEY_MODELLER10v1=' . $ModelerLicense);

exec("mod10.1 loop_refine.py \"$query\" & " , $output3, $retval3);

?>



<script type="text/javascript">
                     
                   
                    
        var myVar = setInterval(checkLog, 4000);
                        
                        
        function checkLog() {    
            
            jQuery("#messages").load('jobs/<?php echo $jobname; ?>/loop_refine.log?v='+Math.floor(Math.random() * 11234242342), 'update=true');
            
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
				ModelerLicense: '<?php echo $ModelerLicense; ?>'
                            }),
                    url: 'loop-refine-third.php',
                    dataType: 'html',
                    success: function(response){ // <--- (data) is in json format
                    
                        jQuery("#response3").html(response);
                        

                        
                        jQuery("#messages").addClass("displayNone");
                        
                        clearInterval(getSteps);
                        
                        jQuery('#loading_text').html("----------------- Model Energies Calculating -----------------");
                  }
                });          
                
                
            }
            
        }
        
</script>
