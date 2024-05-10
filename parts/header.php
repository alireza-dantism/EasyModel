<?php     
    define("SITE_URL", "http://bioinf.modares.ac.ir/software/easymodel");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
		
		<?php 
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            
		    if (strpos($actual_link, 'basic-modelling') !== false) {
		        
		        echo "EasyModel - Basic Modelling";
		        
		    } else if (strpos($actual_link, 'advanced-modelling') !== false) {
		        
		        if ((strpos($actual_link, 'loop-refining') !== false) ) {
		            echo "EasyModel - Advanced Modelling - Loop Refining";
		        } else if ((strpos($actual_link, 'multiple-templates') !== false) ) {
		            echo "EasyModel - Advanced Modelling - Multiple Templates";
		        } else {
		            echo "EasyModel - Advanced Modelling";
		        }
		        
		    } else if (strpos($actual_link, 'documention') !== false) {
		        
		        echo "EasyModel - Documention";
		        
		    } else {
		        echo "EasyModel - protein modeling based on MODELLER";
		    }
        ?>
	</title>
	
	<link rel="icon" href="http://bioinf.modares.ac.ir/software/easymodel/images/favicon.png">
	
    <meta name="author" content="Alireza Dantism">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <link href="<?php echo SITE_URL; ?>/styles/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo SITE_URL; ?>/styles/top_menu.css" rel="stylesheet" />
    <link href="<?php echo SITE_URL; ?>/styles/styles.css?v=0.7" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro'>
    
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/annotations.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>    
        
    <script src="<?php echo SITE_URL; ?>/js/ngl.js"></script>    

    <link href="<?php echo SITE_URL; ?>/styles/dropzone.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo SITE_URL; ?>/js/dropzone.js"></script>    
      
        
    </head>
<body>
<div class="body-bg">
    <img class="img-fluid" src="<?php echo SITE_URL; ?>/images/theme/02_floor_organic_hd_pp-1_3.1900x0.png" />
</div>
<div class="body">
    <header>
    <div class="container">
        <div class="horizental-flex-container">
                <div class="top-header">
                    <div class="left">
						&nbsp;
                    </div>
                    <div class="right">
						<div class="left tell-expert-title font-10 color-b9 ml-4">
Modeller V10.1
                            <?php #Made By TMU Bioinformatics Lab ?>
                        </div>                        
						<div class="left color-df font-16 tell-expert">a_dantism[at]modares.ac.ir</div>
                    </div>
                </div>
        </div>
        <div class="col-md-12 pb-4">
            <div class="left responsive logo col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo SITE_URL; ?>" title="EasyModel">
                    <img class="img-fluid" src="<?php echo SITE_URL; ?>/images/theme/logo.png" alt="EasyModel" title="EasyModel" />
                </a>
            </div>
            <div class="left left-top-header col-md-9 col-sm-6 col-xs-12">
                
				<div class="right col-md-auto col-sm-auto col-xs-auto">
                    
					<div class="left header-three-icons border-50 color-b9" id="menu-icon" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars navbar-toggler"></i>
                    </div>
					<?php /*
                    <div class="left header-three-icons border-50 color-b9 location-icon">
                        <a href="#" title="contact us">
                            <i class="fa fa-map-marker"></i>
                        </a>
                    </div>
                    <div class="left header-three-icons border-50 color-b9 search-icon">
                        <a href="#" target="_blank" title="user">
                            <i class="fa fa-sign-in"></i>
                        </a>
                    </div>
					*/ ?>
                </div>
				
                
                <div id="nav-menu" class="right col-md-11 col-sm-4 col-xs-6">
                    <nav  style="float: right;">
                        <ul>
                            <li class="<?php if ($actual_link == 'http://bioinf.modares.ac.ir/software/easymodel/') {echo 'activeMenu';} ?>"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                            <li class="<?php if (strpos($actual_link, 'basic-modelling') !== false) {echo 'activeMenu';} ?>"><a href="<?php echo SITE_URL; ?>/basic-modelling/">Basic Modelling</a></li>
                            <li class="<?php if (strpos($actual_link, 'loop-refining') !== false) {echo 'activeMenu';} ?>"><a href="<?php echo SITE_URL; ?>/advanced-modelling/loop-refining/">Loop Refining Modelling</a></li>
							<li class="<?php if (strpos($actual_link, 'multiple-templates') !== false) {echo 'activeMenu';} ?>"><a href="<?php echo SITE_URL; ?>/advanced-modelling/multiple-templates/">Multiple Templates Modelling</a></li>
                            <li class="<?php if (strpos($actual_link, 'contact-us') !== false) {echo 'activeMenu';} ?>"><a href="<?php echo SITE_URL; ?>/contact-us">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</header>
	
