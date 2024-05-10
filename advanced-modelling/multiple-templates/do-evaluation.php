<?php
include_once("../../config/config.php");
session_start();

$jobname    =   $_POST['jobname'];


$output=null;
$retval=null;

exec('cp salign.py jobs/' .$jobname. '/salign.py  > /dev/null &', $output, $retval);
exec('cp align2d_mult.py jobs/' .$jobname. '/align2d_mult.py  > /dev/null &', $output, $retval);
exec('cp model_mult.py jobs/' .$jobname. '/model_mult.py  > /dev/null &', $output, $retval);
exec('cp evaluate_model.py jobs/' .$jobname. '/evaluate_model.py  > /dev/null &', $output, $retval);
exec('cp evaluate_template.py jobs/' .$jobname. '/evaluate_template.py  > /dev/null &', $output, $retval);
exec('cp jobs/index.php jobs/' .$jobname. '/index.php  > /dev/null &', $output, $retval);


$sql = "SELECT * FROM easypasy_advanced_multiple_templates WHERE jobname = '$jobname'";
$result = mysqli_query($conn, $sql);

?>

<div class="multipleTemplatesResponse1">

<table  class="table">
    <tr>
        <td>PDB Name</td>
        <td>Chain</td>
    </tr>
    
    <?php
        $c = 1;
        while($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td name="pdbName<?php echo $c; ?>" id="pdbName<?php echo $c; ?>"><?php echo $row['pdb_name']; ?></td>
                    <td>
                        <select name="jobNameChain<?php echo $c; ?>" id="jobNameChain<?php echo $c; ?>">
                            <?php
                                $chainAsArray   =   explode(",",$row['chain']);
                                foreach($chainAsArray as $item) {
                                ?>
                                    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                                <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            <?php
            ++$c;
        }        
        --$c;
    ?>
</table>

</div>

<br/>


<button id="startMultipleModeling">Start Multiple Modelling</button>


<script>

        var getSteps = setInterval(checkSteps, 2000);
        function checkSteps() {
            jQuery("#checkStepText").load('jobs/<?php echo $jobname; ?>/step.txt?v='+Math.floor(Math.random() * 11234242342), 'update=true');
        }
        

jQuery("#startMultipleModeling").click(function(){
	
		jQuery("#getMsg").html("");
		
		var FlagMessage = "";
		var Flag = 1;		
	
		var ModelerLicense =  document.getElementById('modellerlicensekey').value.trim(); 		
		
		if (ModelerLicense == "") {
		   Flag = 0;
		   FlagMessage = "Error: Modeller license key is empty."
		   
		   jQuery('#modellerlicensekey').css('border-color', "#F00");		
		} 

		if (!Flag) {
			jQuery("#getMsg").html(FlagMessage);
			return;
		} 		
    
    jQuery("#loading_progress").removeClass("displayNone");
    jQuery("#checkStepText").removeClass("displayNone");
    jQuery("#loading_text").removeClass("displayNone");
    jQuery("#messages").removeClass("displayNone");
    
    jQuery(".file_upload").addClass("displayNone");
    jQuery("#response").addClass("displayNone");
    
    var makeQuery = "";
    <?php
        for($i = 1;$i <= $c; ++$i) {
            ?>
                var pdbName      = jQuery('#pdbName<?php echo $i; ?>').text();
                var jobNameChain = jQuery('#jobNameChain<?php echo $i; ?>').find(":selected").text();
                
                makeQuery += pdbName.split('.')[0] + "-" + jobNameChain + "#";
            <?php
        }
    ?>

    var modelSeqVar = jQuery('#modelSeq').val()
    
    jQuery.ajax({
        type: 'POST',
        cache: false,
        data: (
                {
                    jobname: <?php echo $jobname; ?>,
                    query: makeQuery,
                    modelSeq: modelSeqVar,
                    ModelerLicense:  ModelerLicense
                }),
        url: 'do-evaluation-second.php',
        dataType: 'html',
        success: function(response){ // <--- (data) is in json format
        
            jQuery("#response2").html(response);

      }
    });    
    

});

              
</script>
