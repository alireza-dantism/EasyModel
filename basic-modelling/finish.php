<?php
    session_start();
    $_SESSION["jobname"] = $_GET['hid'];

    $jobname    =   $_SESSION["jobname"];
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
                            <li><a href="https://9e8.ir/easymodel/basic-modelling/">Basic Modelling</a></li>
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
	


    <div class="cantel-goal-six-box">
        <div class="container">
            <div class="col-md-12">
                

                
                
                <div class="downloadchart" style="text-align: left;">---------------- Here is your files ----------------</i></div>
                                                
                <ul class="finishStepUl" style="border-left: 2px solid #09b70e;padding-left: 10px;margin-bottom: 35px;">
                    <li><a href="https://9e8.ir/easymodel/basic-modelling/jobs/<?php echo $jobname; ?>/Target.pdb"><i class="fa fa-download"></i> Template PDB File</a></li>
                    <li><a href="https://9e8.ir/easymodel/basic-modelling/jobs/<?php echo $jobname . '/' . $best_tempalte; ?>"><i class="fa fa-download"></i> Model PDB File</a></li>
                </ul>
                
                
                <ul class="finishStepUl" style="border-left: 2px solid #ffb100;padding-left: 10px;margin-bottom: 35px;">
                    <li><a href="https://9e8.ir/easymodel/basic-modelling/jobs/<?php echo $jobname; ?>/alignment.ali"><i class="fa fa-download"></i> Alignment.ali</a></li>
                    <li><a href="https://9e8.ir/easymodel/basic-modelling/jobs/<?php echo $jobname; ?>/alignment.pap"><i class="fa fa-download"></i> Alignment.pap</a></li>
                </ul>
                
                
                <ul class="finishStepUl" style="border-left: 2px solid #001fff;padding-left: 10px;margin-bottom: 35px;">
                    <li><a href="https://9e8.ir/easymodel/basic-modelling/jobs/<?php echo $jobname; ?>/evaluate_model.log"><i class="fa fa-download"></i> Evaluate Model Log File</a></li>
                    <li><a href="https://9e8.ir/easymodel/basic-modelling/jobs/<?php echo $jobname; ?>/evaluate_template.log"><i class="fa fa-download"></i> Evaluate Template Log File</a></li>
                    <li><a href="https://9e8.ir/easymodel/basic-modelling/jobs/<?php echo $jobname; ?>/model-single.log"><i class="fa fa-download"></i> Model Single Log File</a></li>
                </ul>

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