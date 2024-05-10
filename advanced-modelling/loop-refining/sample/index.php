<?php
    require '../../../parts/header.php';
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
	exec('zip -r easymodel-all-report-files.zip .');
    
    $getModelsName = [];
    $getModelsDope = [];
    $getModelBoth  = [];
    
    $get_best = fopen("loop_refine.log", "r");
    
    if ($get_best) {
        while (($line = fgets($get_best)) !== false) {
            if (substr("$line", 0, 7 ) === "Model.B") {
                
                $customLine = array_values(array_filter(explode(" ", $line)));
                
                $getModelsName[] = $customLine[0];
                $getModelsDope[] = $customLine[1];
                $getModelBoth[$customLine[0]]  = $customLine[1];
            }
        }
    
        fclose($get_best);
    }
    
$min = min($getModelsDope);
$finalModel = array_search ($min, $getModelBoth);


?>

<div class="downloadchart">
    <div style="background: #b70e0e;
    padding: 4px 33px;
    display: block;
    width: 100%;
    text-align: center;
    margin: 0 auto;
    font-weight: normal;
    max-width: 100%;
    border-radius: 0;
    color: #FFF;"><b>Your accession address is:</b> <?php echo $actual_link; ?></div></div>









<div class="container">


        <div class="row">
            
            <div class="col-sm-6">
  
                <?php
				
				$dirList 	= '.';
				$filesList 	= scandir($dirList);
				rsort($filesList);
				
				foreach ($filesList as $entry) {
					if ($entry != "." && $entry != "..") {
                    
						if (substr("$entry", 0, 7 ) === "Model.B") {
							
					   ?>
						
							<div class="tile form">
								<a href="<?php echo "$entry"; ?>" target="_blank">
									<img src="../../../images/icon-pdb.jpg" alt="Model PDB File" />
									<h3>
										<b>
											<?php 
												if ($finalModel == "$entry") {
													$bestModelLink = $entry;
													echo "** BEST MODEL **";
												} else {echo "$entry";}
											?>
										</b>
									</h3>
								</a>
							</div>                        
						
						<?php							
							
						}
								
					}
				}
				
				
				/*
				if ($handle = opendir('.')) {
				
					while (false !== ($entry = readdir($handle))) {
				
						if ($entry != "." && $entry != "..") {
				
							if (substr("$entry", 0, 7 ) === "Model.B") {
								
								
							?>
							
								<div class="tile form">
									<a href="<?php echo "$entry"; ?>" target="_blank">
										<img src="../../../../images/icon-pdb.jpg" alt="Model PDB File" />
										<h3>
											<b>
												<?php 
													if ($finalModel == "$entry") {
														$bestModelLink = $entry;
														echo "** BEST MODEL **";
													} else {echo "$entry";}
												?>
											</b>
										</h3>
									</a>
								</div>                        
							
							<?php
							} 
							
						}
					}
				
					closedir($handle);
				}
				*/
                ?>
        
                
                <div class="tile form">
                    <a href="model_energies.log" target="_blank">
                        <img src="../../../images/log.png" alt="Evaluate Model Log File" />
                        <h3>model energies <b>Log</b> File</h3>
                    </a>
                </div>
                
                
                <div class="tile form">
                    <a href="loop_refine.log" target="_blank">
                        <img src="../../../images/log.png" alt="Model Single Log File" />
                        <h3>loop refine <b>Log</b> File</h3>
                    </a>
                </div>


				<div class="tile form">
					<a href="easymodel-all-report-files.zip" target="_blank">
						<img src="../../../images/zip.png" alt="Download all Files as a zip" />
						<h3>Download <b>All</b> Files</h3>
					</a>
				</div>				

  
            </div>
            
            
            <div class="col-sm-6">
                <div style="display: block;width: 100%;height: 100%;margin: 0 auto;border-radius: 5px;border: 1px solid #eeeeee;"  id="viewport"></div>
				<a href="<?php echo $bestModelLink; ?>" class="downloadBestModelDirect"><i class="fa fa-download"></i> Download Best Model File</a>
            </div>

        </div>
        
</div>


<?php /*


<div style="display: block;width: 500px;height: 500px;margin: 0 auto;"  id="viewport"></div>

<div class="stage">
  
  <div class="folder-wrap level-current scrolling">
      
  
        
        <?php
            if ($handle = opendir('.')) {
            
                while (false !== ($entry = readdir($handle))) {
            
                    if ($entry != "." && $entry != "..") {
            
                        if (substr("$entry", 0, 7 ) === "Model.B") {
                        ?>
                        
                            <div class="tile form">
                                <a href="<?php echo "$entry"; ?>" target="_blank">
                                    <img src="../../../../images/icon-pdb.jpg" alt="Model PDB File" />
                                    <h3>
                                        <b>
                                            <?php 
                                                if ($finalModel == "$entry") {
                                                    echo "** BEST MODEL **";
                                                } else {echo "$entry";}
                                            ?>
                                        </b>
                                    </h3>
                                </a>
                            </div>                        
                        
                        <?php
                        } 
                        
                    }
                }
            
                closedir($handle);
            }
        ?>

        
        <div class="tile form">
            <a href="model_energies.log" target="_blank">
                <img src="../../../../images/log.png" alt="Evaluate Model Log File" />
                <h3>model energies <b>Log</b> File</h3>
            </a>
        </div>
        
        
        <div class="tile form">
            <a href="loop_refine.log" target="_blank">
                <img src="../../../../images/log.png" alt="Model Single Log File" />
                <h3>loop refine <b>Log</b> File</h3>
            </a>
        </div>
    
  </div><!-- .folder-wrap -->
  
</div><!-- .stage -->
<!-- partial -->

*/ ?>

<script>
    // Create NGL Stage object
    var stage = new NGL.Stage( "viewport" );
    
    // Handle window resizing
    window.addEventListener( "resize", function( event ){
        stage.handleResize();
    }, false );
    
    
    // Load PDB entry 1CRN
    stage.loadFile( "<?php echo $finalModel; ?>", { defaultRepresentation: true } );
</script>


<?php
    include '../../../parts/footer.php';
?>
