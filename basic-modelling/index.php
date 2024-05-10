
<?php
    require '../parts/header.php';
?>

<?php
session_start();

if (!empty($_POST))
{
    
    
    $chain  =   $_POST['chain'];
    if ($chain == "") {
        $chain = "A";
    }
    $_SESSION["chain"]  =   $chain;
    
    $numberOfModels = $_POST['numberOfModels'];
    
    $_SESSION["jobname"] = randomNumber(10);
    mkdir("jobs/" . $_SESSION["jobname"]);

    $tmpTargetFildeDirectory    =   $_POST['jobnameBasic'];
    exec('cp tmp/' . $tmpTargetFildeDirectory . '/Template.pdb jobs/' . $_SESSION["jobname"] . '/Template.pdb > /dev/null &');   
    exec('rm -r tmp/' . $tmpTargetFildeDirectory .' > /dev/null &');   

    $linuXGetSteps = fopen("jobs/" . $_SESSION["jobname"] . "/step.txt", "w") or die("Unable to open file!");
    fwrite($linuXGetSteps, "");
    fclose($linuXGetSteps);    
        
    $flag_error = 0;

    $seq        =   $_POST['fastaseq'];
	$seq 		= str_replace(array("\r", "\n"), '', $seq);

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
        
        $flag_error = 0;
        
        $makePIR    = ">P1;Model";
        $makePIR    .=  "\n";
        $makePIR    .=  "sequence:Model:::::::0.00: 0.00";
        $makePIR    .=  "\n";
        $makePIR    .=  $seq;
        $makePIR    .=  "*";             
        
    }
    
    
    $myfile = fopen("jobs/" . $_SESSION["jobname"] . "/Template.ali", "w") or die("Unable to open file!");
    fwrite($myfile, $makePIR);
    fclose($myfile);    
    
    $modellerLicense = strtoupper($_POST['modellerlicensekey']);

    putenv('KEY_MODELLER10v1=' . $modellerLicense);
    

    
    $output=null;
    $retval=null;
    exec('echo "Our modeling is in the -align2d- step" | tee jobs/' . $_SESSION["jobname"] . '/step.txt && ' 
         . 'mod10.1 align2d.py ' . $_SESSION["jobname"] . ' ' . $chain . ' && ' 
         . ': > jobs/' . $_SESSION["jobname"] . '/step.txt && ' 
         . 'echo "Our modeling is in the -model-single- step" | tee jobs/' . $_SESSION["jobname"] . '/step.txt && ' 
         . 'cp model-single.py jobs/' . $_SESSION["jobname"] . '/model-single.py && ' 
         . 'cp jobs/index.php jobs/' . $_SESSION["jobname"] . '/index.php' . '>  /dev/null &', $output, $retval);

    // ------------------------------ STEP 1 
         
    $output2=null;
    
    chdir('jobs/' . $_SESSION["jobname"]);
    
    exec('mod10.1 model-single.py ' . $chain . ' ' . $numberOfModels . ' > /dev/null &', $output2, $retval2);   
    
    ?>
    
    <script type="text/javascript">
        
        var getSteps = setInterval(checkSteps, 2000);
        function checkSteps() {
            jQuery("#checkStepText").load('jobs/<?php echo $_SESSION["jobname"]; ?>/step.txt?v='+Math.floor(Math.random() * 5643223243), 'update=true');
        }
        
                    
        var myVar = setInterval(checkLog, 4000);
                        
                        
        function checkLog() {    
            
            jQuery("#messages").load('jobs/<?php echo $_SESSION["jobname"]; ?>/model-single.log?v='+Math.floor(Math.random() * 534553543), 'update=true');
            
            var log_data = jQuery('#messages').text();
            
            
            jQuery("#messages").animate({ scrollTop: $('#messages').prop("scrollHeight")}, 1000);

            
            if (log_data.indexOf("Total CPU time [seconds]") >= 0) {
                
                clearInterval(myVar);
                
                jQuery.ajax({
                    type: 'POST',
                    cache: false,
                    data: ({jobname: <?php echo $_SESSION["jobname"]; ?>,chain: '<?php echo $chain; ?>',modellerLicense: '<?php echo $modellerLicense; ?>' }),
                    url: 'do-evaluation.php',
                    dataType: 'html',
                    success: function(response){ // <--- (data) is in json format
                    
                        clearInterval(getSteps);
                    
                        jQuery("#loading_progress").addClass("displayNone");
                        jQuery("#loading_text").text("Your Tracking Code Is: " + <?php echo $_SESSION["jobname"]; ?>);
 
                        jQuery("#checkStepText").text("");
 
                        jQuery("#buildProfile").html(response);
                        
                        jQuery("#messages").addClass("displayNone");
                        
                        
                    //parse the json data
                  }
                });                
                
            }            
            
        }
        
    </script>
    
    <?php
     
    
}

function randomNumber($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(1, 9);
    }

    return $result;
}

?>

    <p></p>

    <div class="cantel-goal-six-box">
        <div class="container">
            <div class="col-md-12">
                
                <h1 class="centerForm">Basic Modelling</h1>
<div class="centerForm sampleLink">
A sample of the Basic Modelling result can be found <a href="http://bioinf.modares.ac.ir/software/easymodel/basic-modelling/sample" target="_blank">here</a>.                
</div>
                
            </div>
        </div>
    </div>

    <div class="cantel-goal-six-box">
        <div class="container">
            <div class="col-md-12">
                
                <?php
                    if (empty($_POST))
                    {
                ?>
                
                        <form action="file_upload.php" method="POST" class="basicModelFormUi centerForm dropzone" enctype="multipart/form-data">

							<label for="modellerlicensekey">Modeller License Key</label> <br/>
<span>To obtain a license key, visit <a href="https://salilab.org/modeller/registration.html" target="_blank" style="color: red;cursor: pointer;">The Modeller web page.</a></span>
                            <input type="text" id="modellerlicensekey" name="modellerlicensekey" />			
							<br/><br/>

                            <label for="fastaseq">Model Sequence</label> <br/>
                            <textarea id="fastaseq" name="fastaseq" rows="6" placeholder="Only Amino Acids are acceptable. eg: AFKDIDCAFLVAS"></textarea>
                            
                            <label for="choosePdb">Template pdb file</label> <br/>
                            <select id="pdbAccess">
                                <option>Upload .pdf file</option>
<?php /*                                <option>With pdb id</option> */ ?>
                            </select>
							                            
                            <input type="text" id="pdbIdFromRCSB" name="pdbIdFromRCSB" placeholder="PDB code" class="displayNone" />
                            
                            <div id="checkPdbFileExist"  class="displayNone">check your pdb id availability</div>
            
		
                            <?php $rand = date('YmdHis'); ?>
                            <div class="dz-message-basic needsclick"></div>

                            <br/>
                            
                            <div id="checkCHains"></div>
                            
                            <br/>

                            <div id="getMsg"></div>
                            
                            <div id="loading_progress" class="displayNone"><img src="<?php echo SITE_URL; ?>/images/loading.gif" alt="loading"></div>

                            <?php // Hidden inputs ?>
                            <input type="hidden" name="jobnameBasic" id="jobnameBasic" value="<?php echo $rand; ?>" />
                            <input type="hidden" name="jobname" id="jobname" value="" />
                            <input type="hidden" name="jobnameLoop" id="jobnameLoop" value="" />
                            
                        </form>
                        
                        
                <?php
                    } else {
                ?>
                        
                        <div id="loading_text" class="blink"><span>Server is working on it - please wait ...</span></div>
                        
                        <div id="checkStepText">--</div>
                        
                        <div id="loading_progress" class="displayBlock"><img src="<?php echo SITE_URL; ?>/images/loading.gif" alt="loading" /></div>
                                     
                        <div id="messages" style="height: 200px;display: block;background: #f1bd46;overflow: scroll;white-space: pre;margin: 30px auto;width: 70%;border-radius: 5px;color: #000;" ></div>                                         
                                     
                <?php
                    }
                ?>
                
                <div id="buildProfile"></div>
                
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

  


<?php
    include '../parts/footer.php';
?>
