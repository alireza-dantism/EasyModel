<?php
session_start();
$_SESSION["jobname"] = $_GET['hid'];









$model = [];
$handle = fopen('jobs/' . $_SESSION["jobname"] . '/TargetA.profile', "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        
        
        if (trim(substr( $line, 0, 1 )) == "#" || empty(trim($line))) {
        //   break;
        
        } else {
            // array_filter(explode(" ",$line));
            
            $string1    = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($line));  
            
            $string2    = str_replace(" ",",",$string1);
            $arr = explode(",", $string2);
            $string2    = end($arr);

            
            $model[] =  (float)$string2;
            
            
        }
        
    }

    fclose($handle);
}
// *****************************




$template = [];
$handle = fopen('jobs/' . $_SESSION["jobname"] . '/Template.profile', "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        
        if (trim(substr( $line, 0, 1 )) == "#" || empty(trim($line))) {
        //   break;
        
        } else {
            // array_filter(explode(" ",$line));
            
            $string1    = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($line));  
            
            $string2    = str_replace(" ",",",$string1);
            $arr = explode(",", $string2);
            $string2    = end($arr);
            
            $template[] =  (float)$string2;
            
            
        }
        
    }

    fclose($handle);
}

// --------------------------------------------------------------------------------------------



$oio    = 0;
$gaps   = [];
$handle = fopen('jobs/' . $_SESSION["jobname"] . '/alignment.ali', "r");

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        
        if ($line == "\n" || trim(substr( $line, 0, 1 )) == ">" || trim(substr( $line, 0, 10 )) == "structureX") { } else { $gaps[] =  $line; }
        
        if (substr(trim($line), -1) == '*' && $oio == 0) 
            break;
            
    }

    fclose($handle);
}


/* -------- MODEL --------------------- */

$gaps_string    =   implode("",$gaps);
$gaps_string    =   str_replace(array("\n", "\r"), '', $gaps_string);
$gaps_string    =   rtrim($gaps_string, "*");

$array = str_split($gaps_string);

$char_index =   0;
$gap_array = array();
foreach ($array as $char) {
    if ($char == "-") {
        $gap_array[]    =   $char_index;
    }
    ++$char_index;
}



foreach ($gap_array as $item) {
    $inserted = array( 'null' );
    array_splice( $model, $item, 0, $inserted );
}


/* -------- ------ --------------------- */







/* -------- Template --------------------- */
$oio    = 0;
$gaps   = [];
$gaps_string = "";
$handle = fopen('jobs/' . $_SESSION["jobname"] . '/alignment.ali', "r");

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        
        if ($line == "\n" || trim(substr( $line, 0, 1 )) == ">" || trim(substr( $line, 0, 10 )) == "structureX") { } else { $gaps[] =  $line; }
        
        if (substr(trim($line), -1) == '*' && $oio == 0) {
            //break;
            $oio = 1;
            $gaps = [];
        }
    }

    fclose($handle);
}

unset($gaps[0]);


$gaps_string    =   implode("",$gaps);
$gaps_string    =   str_replace(array("\n", "\r"), '', $gaps_string);
$gaps_string    =   rtrim($gaps_string, "*");


$array = str_split($gaps_string);

$char_index =   0;
$gap_array = array();
foreach ($array as $char) {
    if ($char == "-") {
        $gap_array[]    =   $char_index;
    }
    ++$char_index;
}



foreach ($gap_array as $item) {
    $inserted = array( 'null' );
    array_splice( $template, $item, 0, $inserted );
}

/* -------- -------- --------------------- */










$template_str   =   "[";
foreach ($template as $key => $value) {
    if ($key+1 == count($template)) {
        $template_str .= $value;
    } else {
        $template_str .= $value . ',';
    }
}
$template_str   .=   "]";




$model_str   =   "[";
foreach ($model as $key => $value) {
    
    if ($key+1 == count($model)) {
        $model_str .= $value;
    } else {
        $model_str .= $value . ',';
    }
}
$model_str   .=   "]";

// $template
// $model

// --------------------------------------------------------









?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EasyModel</title>
    <meta name="author" content="Alireza Dantism">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/top_menu.css" rel="stylesheet" />
    <link href="../styles/styles.css?v=0.7" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
    
    <!-- partial:index.partial.html -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/annotations.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>    
    
<body>
<div class="body-bg">
    <img class="img-fluid" src="../images/theme/02_floor_organic_hd_pp-1_3.1900x0.png" />
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
                            Made By TMU Bioinformatics Lab
                        </div>                        
						<div class="left color-df font-16 tell-expert">info[at]easymodel.org</div>
                    </div>
                </div>
        </div>
        <div class="col-md-12 pb-4">
            <div class="left responsive logo col-md-3 col-sm-6 col-xs-12">
                <a href="" title="EasyModel">
                    <img class="img-fluid" src="../images/theme/logo.png" alt="EasyModel" title="EasyModel" />
                </a>
            </div>
            <div class="left left-top-header col-md-9 col-sm-6 col-xs-12">
                <div class="right col-md-auto col-sm-auto col-xs-auto">
                    <div class="left header-three-icons border-50 color-b9" id="menu-icon" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars navbar-toggler"></i>
                    </div>
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
                </div>
                <div id="nav-menu" class="right col-md-9 col-sm-4 col-xs-6">
                    <nav>
                        <ul>
                            <li class="activeMenu"><a href="">Home</a></li>
                            <li><a href="">Documention</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/basic-modelling/">Basic Modelling</a></li>
                            <li><a href="">Advanced Modelling</a></li>
                            <li><a href="">About Us</a></li>
                            <li><a href="">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</header>
	
  
    <div class="cantel-goal">
        <div class="container">
            <div class="col-md-12 mb-5 mt-5">
                
                <form id="msform">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" id="account"><strong>Fill-Data-Align2d.py</strong></li>
                        <li id="personal" class="active"><strong>Model-Single</strong></li>
                        <li id="payment" class="active"><strong>Evaluate-ModelTemplate</strong></li>
                        <li id="confirm" class="active"><strong>Create-Plot</strong></li>
                        <li id="evaluate"><strong>Finish</strong></li>        
                    </ul>                
                </form>
                
            </div>
        </div>
    </div>

    <div class="cantel-goal-six-box">
        <div class="container">
            <div class="col-md-12">
                
                
                <div class="downloadchart">Also you can export your chart by clicking on burger menu -> <i class="fa fa-bars"></i></div>
                                
                                
                <div id="makeChartPlot"></div>
                <!-- partial -->
                
                <a class="finishStep" href="<?php echo SITE_URL; ?>/basic-modelling/finish.php?hid=<?php echo $_SESSION["jobname"]; ?>">Download and finish the basic modelling you did</a>
                
                <script>
                var colors = ['#086708', '#f00'];
                Highcharts.chart('makeChartPlot', {
                
                    title: {
                        text: 'Plot Profiles'
                    },
                    yAxis: {
                        title: {
                            text: 'DOPE per-residue score'
                        }
                    },
                    colors:colors,
                    
                     series: [
                         
                         {
                        name: 'Template',
                        data: <?php echo $model_str; ?>
                    }
                    
                    , {
                        name: 'Model',
                        data: <?php echo $template_str; ?>
                    }
                    
                    ],
                
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 650
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                
                });
                </script>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

  


  <footer>

    <div class="container">
        <div class="col-md-12">
            <div class="left col-md-6 col-sm-6 col-xs-12">
                <div class="left footer-menu-right col-md-9 col-sm-9 col-xs-9 pr-2">
                    <div class="right col-md-12">
                        <div class="footer-menu-title font-18 color-yellow">Usefull Links</div>
                        <div class="footer-menu-link mt-2">
                            <ul>
                                <li class="font-12 color-68">
                                    <a href="#" title="TMU">Tarbiat Modares University</a>
                                </li>
                                <li class="font-12 color-68">
                                    <a href="#" title="TMU Bioinformatics Lab">TMU Bioinformatics Lab</a>
                                </li>
                                <li class="font-12 color-68">
                                    <a href="#" title="Modeller">Modeller</a>
                                </li>
								<li class="font-12 color-68">
                                    <a href="#" title="Policy">Policy</a>
                                </li>
                                <li class="font-12 color-68">
                                    <a href="#" title="Salilab">Salilab.org</a>
                                </li>
                                <li class="font-12 color-68">
                                    <a href="#" title="Support">Support</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="left footer-menu-img col-md-3 col-sm-3 col-xs-3 text-center mt-4 pl-2">
                    <img class="img-fluid" src="../images/theme/small-logo.png" alt="کنتل" title="کنتل" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="left col-md-6 col-sm-6 col-xs-12 pl-4">
                <div class="left footer-left-box col-lg-10 col-md-9 col-sm-10 col-xs-10">
                    <div class="color-yellow font-18">
                        SOMETHING KNOW ABOUT OUR LAB ...
                    </div>
                    <div class="color-a5 mb-3 mt-2 footer-left-text">
						Our research area includes but not limited to protein tertiary structure prediction, protein structure determination from experimental data, DNA and RNA structure, and algorithms for addressing the recent problem in systems biology, functional genomics and other omics ...
                    </div>
                    <div class="color-a5">
                        <a href="#" title="about us">
							<i class="fa fa-chevron-circle-right color-a5 ml-1"></i> read more
                        </a>
                    </div>
                </div>
                <div class="right social-network col-lg-2 col-md-3 col-sm-2 col-xs-2">
                    <div class="social-network-box right">
                        <a href="#" target="_blank" title="EasyModel - Github">
                            <i class="fa fa-angle-right right color-b9"></i>
                            <i class="fa fa-github left font-15 color-8e"></i>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                    <div class="social-network-box right">
                        <a href="#" target="_blank" title="EasyModel - Mailing">
                            <i class="fa fa-angle-right right color-b9"></i>
                            <i class="fa fa-envelope left font-15 color-8e"></i>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                    <div class="social-network-box right">
                        <a href="#" title="EasyModel - GooglePlus" target="_blank" >
                            <i class="fa fa-angle-right right color-b9"></i>
                            <i class="fa fa-google-plus left font-15 color-8e"></i>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-12 mt-5 mb-3">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-6 col-xs-12 right font-11 color-a5 mt-3 copyrights">
                    <div class="mb-3">
                        <div>
							Copyright © 2021 Tarbiat Modares University - The EasyModel Project is supported in Bioinformatics Lab. All rights reserved.
						</div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 left font-11 color-a5 mt-3">
                    <div class="mb-3 left">
                        <div>Designed by <a href="#" target="_blank">Seyed Shahriar Arab & Alireza Dantism</a></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</footer>


<script type="application/javascript" src="../js/jQuery.js"></script>
<script type="application/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/custom.js"></script>
<script type="application/javascript" src="../js/top_menu.js"></script>

</body>
</html>