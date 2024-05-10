
<?php
    require 'parts/header.php';
?>
  
    <div class="cantel-goal">
        <div class="container">
            <div class="col-md-12 mb-5 mt-5">
                <div class="cantel-goal-first-title font-18 color-8e">
                    EasyModel: A User-Friendly Web-Based Interface Based on MODELLER
                </div>
                <div class="cantel-goal-second-title font-12 mt-1">
					In this interface, we use the homology modeling method. The basis of prediction by homologous modeling is that the
protein sequence is similar to one or more proteins with a known structure. 
                </div>
            </div>
        </div>
    </div>

    <div class="cantel-goal-six-box">
        <div class="container">
            <div class="col-md-12">
                <div class="right six-box pr-2 p-2">
                    <div class="odd-box">
                        <a href="<?php echo SITE_URL; ?>/advanced-modelling/multiple-templates">
						<img src="<?php echo SITE_URL; ?>/images/multiple-template.jpg" alt="Easymodel - Advanced Modeling - Multiple Templates" />
                        <div class="font-20 color-81 mb-4">Advanced Modeling - Multiple Templates</div>
                        <div class="font-12 color-81">
                            <span>Model a sequence with high identity to multiple templates.</span>
							<p>
								Build a model using information from multiple templates, provide an alignment between all of the templates and your target sequence and list all of the templates in the knowns argument.
							</p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="right six-box pr-2 p-2">
                    <div class="even-box">
                        <a href="<?php echo SITE_URL; ?>/advanced-modelling/loop-refining">
						<img src="<?php echo SITE_URL; ?>/images/loop-refinment.jpg" alt="Easymodel - Advanced Modeling - Loop Refining" />
                        <div class="font-20 color-81 mb-4">Advanced Modeling - Loop Refining</div>
                        <div class="font-12 color-81">
                            <span>The loop optimization relies on a scoring function and optimization schedule adapted for loop modeling.</span>
							<p>
								Select any set of atoms of your choosing model and generating  a number of loop models.
							</p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="right six-box pr-2 p-2">
                    <div class="odd-box">
                        <a href="<?php echo SITE_URL; ?>/basic-modelling/">
						<img src="<?php echo SITE_URL; ?>/images/basic-modelling.jpg" alt="Easymodel - Basic Modeling" />
                        <div class="font-20 color-0c mb-4">Basic Modeling</div>
                        <div class="font-12 color-0c">
                           <span>Model a sequence with high identity to a template.</span>
						   <p>
This section use a simple case where the template selection and target-template alignments are not a problem.
This means that there is no gap between the amino acids.
						   </p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

  


<?php
    require 'parts/footer.php';
?>