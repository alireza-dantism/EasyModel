<?php
session_start();
$_SESSION["jobname"] = randomNumber(10);



function randomNumber($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}
?>

<?php
    require '../../parts/header.php';
?>
	
  
    <div class="cantel-goal">
        <div class="container">
            <div class="col-md-12 centerForm">
                <br/>
                <h1>Advanced Modelling - Multiple Templates</h1>
<div class="sampleLink">
A sample of the Multiple Templates result can be found <a href="http://bioinf.modares.ac.ir/software/easymodel/advanced-modelling/multiple-templates/sample" target="_blank">here</a>.                
</div>
                <br/>
            </div>
        </div>
    </div>

    <div class="cantel-goal-six-box">
        <div class="container">
            <div class="col-md-12">
              
            	<div class="file_upload">
            		<form action="file_upload.php" class="basicModelFormUi centerForm dropzone" method="POST" enctype="multipart/form-data">
            		    
						<label for="modellerlicensekey">Modeller License Key</label><br/>
<span>To obtain a license key, visit <a href="https://salilab.org/modeller/registration.html" target="_blank" style="color: red;cursor: pointer;">The Modeller web page.</a></span>
						<input type="text" id="modellerlicensekey" name="modellerlicensekey">
						
						<br/>
						<br/>
						
                        <label>Your Model Sequence</label><br/>
                        <textarea name="modelSeq" id="modelSeq" placeholder="Only Amino Acids are acceptable. eg: AFKDIDCAFLVAS" rows="6" cols="50"></textarea>            		    
            		    
            		    <label>Template PDB Files</label><br/>
            			<div class="dz-message needsclick">
            				<strong>Choose or drop Template PDB files here to upload</strong><br />
            			</div>
            			<input type="hidden" name="jobname" id="jobname" value="<?php echo $_SESSION["jobname"]; ?>" />
            			
                        <?php // Hidden inputs ?>
                        <input type="hidden" name="jobnameBasic" id="jobnameBasic" value="" />
                        <input type="hidden" name="jobnameLoop" id="jobnameLoop" value="" />
                        <input type="hidden" name="jobname" id="jobname" value="<?php echo $_SESSION["jobname"]; ?>" />
            			
            		</form>		
            	</div>	              
              
                <p>&nbsp;</p>
              
                <div id="response" class="centerForm"></div>
                
				<br/>
				
				<div id="getMsg"></div>
				
                
                <div id="loading_text" class="blink displayNone"><span>Servers are working on it - please wait ...</span></div>
                
                <div id="checkStepText" class="displayNone">--</div>
                
                <div id="loading_progress" class="displayNone"><img src="<?php echo SITE_URL; ?>/images/loading.gif" alt="loading" /></div>
                
                
                <div id="messages"  class="displayNone" style="height: 200px;display: block;background: #f1bd46;overflow: scroll;white-space: pre;margin: 30px auto;width: 70%;border-radius: 5px;color: #000;"></div>
                    
                <div id="response2" class="displayNone"></div>
                
                <div id="response3"></div>
                   
              
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

<?php
    require '../../parts/footer.php';
?>
