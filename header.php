<!doctype html>
<!--[if lt IE 7]>      <html class="lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title></title>

	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width,initial-scale=1">

	<!--Twitter Bootstrap CDN-->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
        
    <link rel="stylesheet" href="css/main.css?v=0.001">
    
</head>
<body>
    
    <div id="access" role="navigation" class="hidden">
        <a href="#content">Skip to content</a>
    </div><!-- /access -->
    
    <!--[if lt IE 8]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    
    <div class="">
        
        <div class="wrap">
            
            <div class="row">
                <div class="col-md-2 left-bar">
                    
                    <div class="logo"><a href="index.php">Edit<span>Lite</span></a></div>
                    
                    <nav class="navigation">
                        <ul class="nav nav-pills nav-stacked">
                        
                            <?php if ($tables) {
                                $i = 1;
                                foreach ($tables as $t) { ?>
                                    <li class="<?php echo ($table == $t->$colName) ? $table : (($table == '') && ($i == 1)) ? 'active' : '';?>"><a href="index.php?table=<?php echo $t->$colName;?>"><?php echo EditLite::getNiceName($t->$colName);?></a></li>
                                    <?php
                                    $i++;
                                }
                            } ?>
                        </ul>
                    </nav><!--/navigation-->
                </div><!--/col-md-2-->
                
                <div id="content" class="col-md-10">
                    