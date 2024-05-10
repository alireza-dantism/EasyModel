<?php
include_once("../../config/config.php");
session_start();

$jobname    =   $_POST['jobname'];

$output=null;
$retval=null;

exec('cp step.txt jobs/' .$jobname. '/step.txt  > /dev/null &', $output, $retval);
exec('cp jobs/index.php jobs/' .$jobname. '/index.php  > /dev/null &', $output, $retval);
exec('cp loop_refine.py jobs/' .$jobname. '/loop_refine.py  > /dev/null &', $output, $retval);
exec('cp model_energies.py jobs/' .$jobname. '/model_energies.py  > /dev/null &', $output, $retval);

$sql = "SELECT * FROM easypasy_advanced_multiple_templates WHERE jobname = '$jobname'";
$result = mysqli_query($conn, $sql);

?>

<div class="multipleTemplatesResponse1">

<table  class="table">
    <tr>
        <td>Chain</td>
        <td>Residue Range From</td>
        <td>Residue Range To</td>
    </tr>
    
    <?php
        $c = 1;
        while($row = mysqli_fetch_assoc($result)) {
			
			$pdbName_NGL = $row['pdb_name'];
			
            ?>
                <tr>
                    <td>
                        <select  onchange="selectRes()" name="jobNameChain<?php echo $c; ?>" id="jobNameChain<?php echo $c; ?>">
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
                    <td>
                        <input type="text" name="jobNameResiduFrom<?php echo $c; ?>" id="jobNameResiduFrom<?php echo $c; ?>"  onkeyup="selectRes()" />
                    </td>
                    <td>
                        <input type="text" name="jobNameResiduTo<?php echo $c; ?>" id="jobNameResiduTo<?php echo $c; ?>"  onkeyup="selectRes()" />
                    </td>
                    <td style="display: none;">
                        <div name="pdbName" id="pdbName"><?php echo $row['pdb_name']; ?></div>
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

<div style="display: block;width: 100%;height: 400px;margin: 0 auto;border-radius: 5px;border: 1px solid #eeeeee;"  id="viewport"></div>


<br/>


<button id="startLoopRefining">Start Loop Refining</button>



<script>

    jQuery("#startLoopRefining").click(function(){
		
		jQuery("#getMsg").html("");
		
		var fromCheck = document.getElementById("jobNameResiduFrom<?php echo $c; ?>").value;
		var toCheck   = document.getElementById("jobNameResiduTo<?php echo $c; ?>").value;
		var chainCheck = toCheck - fromCheck;
		
		var FlagMessage = "";
		var Flag = 1;		
	
		var ModelerLicense =  document.getElementById('modellerlicensekey').value.trim(); 		
		
		if (ModelerLicense == "") {
		   Flag = 0;
		   FlagMessage = "Error: Modeller license key is empty.";
		   
		   jQuery('#modellerlicensekey').css('border-color', "#F00");		
		} 

		if (chainCheck > 20) {
		   Flag = 0;
		   FlagMessage = "Error: You should select residue range less than 20."
		   
		}	

		if (!Flag) {
			jQuery("#getMsg").html(FlagMessage);
			return;
		} 	
		
		jQuery('#modellerlicensekey').removeAttr("style");
        
        jQuery("#loading_progress").removeClass("displayNone");
        jQuery("#checkStepText").removeClass("displayNone");
        jQuery("#loading_text").removeClass("displayNone");
        jQuery("#messages").removeClass("displayNone");
        
        jQuery(".file_upload").addClass("displayNone");
        jQuery("#response").addClass("displayNone");
		
				
        
        var makeQuery = "";

        var pdbName                = jQuery('#pdbName').text();        
        var jobNameChain           = jQuery('#jobNameChain1').find(":selected").text();
        var jobNameResiduFrom      = jQuery('#jobNameResiduFrom1').val();
        var jobNameResiduTo        = jQuery('#jobNameResiduTo1').val();
        
        makeQuery += jobNameChain + " " + jobNameResiduFrom + " " + jobNameResiduTo + " " + pdbName;
		

		jQuery.ajax({
			type: 'POST',
			cache: false,
			data: (
					{
						jobname: <?php echo $jobname; ?>,
						query: makeQuery,
						ModelerLicense: ModelerLicense
					}),
			url: 'loop-refine-second.php',
			dataType: 'html',
			success: function(response){ // <--- (data) is in json format
			
				jQuery("#response2").html(response);
	
		  }
		});   
    
    });
              
</script>



<script>
    function selectRes() {
      var from = document.getElementById("jobNameResiduFrom<?php echo $c; ?>").value;
      var to   = document.getElementById("jobNameResiduTo<?php echo $c; ?>").value;
	  
	  
		jQuery("#getMsg").html("");
	  if (to - from <= 20 && to - from >= 10) {
  			jQuery("#getMsg").html("<br/><span style='color: #d5931b;text-align: center;'>Warning: Loop Refining is limited in its effectiveness for large segments and may not achieve the required level of accuracy.</span>");   	
		}	
      
      var select = from + "-" + to;
      
        var schemeId = NGL.ColormakerRegistry.addSelectionScheme([
          ["yellow", select],
          ["green", "*"]
        ]);         
        
        var chain = jQuery('#jobNameChain<?php echo $c; ?>').find(":selected").text();
        
        stage.loadFile("jobs/<?php echo $jobname; ?>/<?php echo $pdbName_NGL; ?>").then(function (o) {
          o.addRepresentation("tube");
          o.addRepresentation("tube", {color: schemeId , sele: ":" + chain});  // pass schemeId here
          o.autoView();
        });  
    }    
</script>




<script>
    // Create NGL Stage object
    var stage = new NGL.Stage( "viewport" );
    
    // Handle window resizing
    window.addEventListener( "resize", function( event ){
        stage.handleResize();
    }, false );
    
   
    
    // Load PDB entry 1CRN
    <?php /* stage.loadFile( "jobs/<?php echo $jobname; ?>/Template.pdb", { defaultRepresentation: true } ); */ ?>

        
    stage.loadFile("jobs/<?php echo $jobname; ?>/<?php echo $pdbName_NGL; ?>").then(function (o) {
      o.addRepresentation("tube");
    });

stage.mouseControls.add("drag-left+right", NGL.MouseActions.zoomDrag);
    
    
</script>
