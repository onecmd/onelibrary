<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
	<title>Onelibrary Library Center - Chengdu</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/3.2.0/css/bootstrap.min.css">	
	<!-- Optional theme -->
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/3.2.0/css/bootstrap-theme.min.css">	
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/bootstrap-datetimepicker.min.css">	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/jquery/jquery-1.11.1.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/bootstrap3-typeahead.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/bootstrap-datetimepicker.fr.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/chart/Chart.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/html5shiv.min.js"></script>
      <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/respond.min.js"></script>
    <![endif]-->
    
    <style type="text/css">
    	body{color:#0088ff;font-size:13px;}
    	#nav_head .active>a{color:#eee;background-image: linear-gradient(to bottom,#0066cc 0,#0066cc 100%);}
    	#nav_head .active>a:hover{color:#fff;}
    	#nav_head li>a{color:#fff;}
    	#nav_head li>a:hover{color:#77b8ce;}
    	#nav_head .tab-content .active{color:#eee;background-color:#0066cc;}
    	.breadcrumb{margin-bottom:0px;background-color:#0066cc;color:#eee;padding-top:0px;padding-bottom:0px;}
    	.breadcrumb>li{padding:8px 8px 8px 0px;}
    	.breadcrumb>li:hover{background-color:#0088FF;}
    	.breadcrumb a{color:#fff;}
    	.breadcrumb a:hover{color:#ccc;text-decoration:none;}
    	.breadcrumb .active{background-color:#0088FF;}
    	.breadcrumb>li+li:before{content: "|\00a0";}
    	.carousel-inner .active{background-color:#0066cc;}
    	#mycarousel{padding:8px 8px 8px 0px;}
    	#nav_myinfo a{color:#fff;}
    	#nav_myinfo a:hover{color:#ccc;}
    	.index_nav_right{clear:both;font-size:13px;padding:5px 5px 5px 5px; border-bottom:1px solid #0088FF;margin-bottom:5px;}
    </style>
  </head>
  <body style="padding-bottom:70px;background-color:#f2f2f2;">
<nav class="navbar navbar-default" role="navigation" style="margin-bottom:15px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" >
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topmenu">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="background-color: #eee;color:#124191;font-size:14px;font-weight:bold;">
      	<!--  <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/nokia-logo.jpg" border="0" style="height:15px;padding:0px 0px 0 10px;"> 
      	-->
      	Onelibrary LIBRARY
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="topmenu" style="background-color: #124191; ">
      <ul class="nav navbar-nav" id="nav_head">
      	<?php 
      		$controlId =  Yii::app()->controller->id;	
      		$actionId =  Yii::app()->getController()->getAction()->id;
      		$module = $this->getModule();
      		$moduleId = isset($module) ? $module->id : "default";
      		//echo       	$moduleId;	
      	?>
        <li class="<?php echo $moduleId=="default"? "active":"" ?>"><a href="<?php echo Yii::app()->createUrl("default/index") ?>">Home</a></li>
        <li class="<?php echo $moduleId=="library"? "active":"" ?>"><a href="<?php echo Yii::app()->createUrl("library/default/index") ?>">Library</a></li>
        <?php /*?>
          <li class="<?php echo $moduleId=="blogs"? "active":"" ?>"><a href="<?php echo Yii::app()->createUrl("blogs/default/index") ?>">Blogs</a></li>
        <li class="<?php echo $moduleId=="tuhome"? "active":"" ?>"><a href="<?php echo Yii::app()->createUrl("tuhome/default/index") ?>">TU Home</a></li>
        <?php */ ?>
        <li class="<?php echo $moduleId=="my"? "active":"" ?>"><a  href="<?php echo Yii::app()->createUrl("my/default/index") ?>">My Center</a></li>
        <!--  
        <li class="<?php echo $moduleId=="tubbs"? "active":"" ?>"><a  href="http://10.140.1.39/" target="_blank">TU BBS</a></li>
        -->
        <?php /*?>
        <li class="<?php echo $actionId=="navigate"? "active":"" ?>"><a  href="<?php echo Yii::app()->createUrl("navigate/default/index") ?>">Navigator</a></li>
      	<?php */?>
      </ul>
      <ul class="nav navbar-nav navbar-right" id="nav_myinfo">
      	<?php 
      		if(isset(Yii::app()->session['user']))
      		{
      	?>
        <li><a href="<?php echo Yii::app()->createUrl("default/logout") ?>">LOGOUT</a></li>
        <?php 
      		}
      		else 
      		{
        ?>
        <li><a href="<?php echo Yii::app()->createUrl("default/login") ?>">LOGIN</a></li>
        <?php 
      		}
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
    <div class="tab-content">
    	<?php 
    		if($moduleId=="default") 
    		{
    	?>
		<div class="tab-pane <?php echo $moduleId=="default"? "active":"" ?>" id="home">
		  	<ol class="breadcrumb" style="background-color:#0066cc;color:#eee;">
		  		<div id="mycarousel" class="carousel slide" data-ride="carousel" style="width:700px">
			  		<div class="carousel-inner" style="color:#00ee00">
			  			<div class="item active">[1/3] Welcome to visit Chengdu Trade Union Library Website!</div>
			  			<div class="item">[1/3] Highly suggest you visit the website with Chrome Browser!</div>
			  			<div class="item">[2/3]Library website is ready！</div>
			  		</div>
			  		<script language="javascript">
			  		$(".carousel").carousel({interval:2000,wrap:true,})
			  		</script>
		  		</div>
		  	</ol> 
		</div>
		<?php 
    		}
			else if($moduleId=="library")
			{
		?>
		 <div class="tab-pane active" id="library">
		 	<ol class="breadcrumb">
			  <li <?php echo $controlId=='default'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/default/index") ?>">Index</a></li>
			  <li <?php echo $controlId=='search'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/search/index") ?>">Search Books</a></li>
			  <li <?php echo $controlId=='donate'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/donate/index") ?>">捐书光荣榜</a></li>
			  <li <?php echo $controlId=='buy'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/buy/index") ?>">心愿书单</a></li>
			  <?php 
			  	if(isset(Yii::app()->session['user']))
			  	{
			  ?>
			  <li <?php echo $controlId=='my'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/my/index") ?>">My Library</a></li>
			  <?php 
			  		//echo RoleUtil::getUserLibraryRole()." ====== ".RoleUtil::$LIBRARY_ROLE["Libration"];
			  		if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["Libration"]-1)
			  		{
			  ?>
			  <li <?php echo $controlId=='manage'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/manage/index") ?>">Manage Books</a></li>
			  <li <?php echo $controlId=='edit'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/edit/add") ?>" target="_blank">Add Books</a></li>
			  <?php 
			  		if(RoleUtil::getUserLibraryRole()>RoleUtil::$LIBRARY_ROLE["SuperAdmin"]-1)
			  		{
			  ?>
			  <li <?php echo $controlId=='setting'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("library/setting/index") ?>">Setting</a></li>
				<?php 
			  		} // end admin
				?>
			  <?php 
			  		}
				}
			?>
			</ol>
		</div>
		<?php 
    		}
			else if($moduleId=="blogs")
			{
		?>
		<div class="tab-pane <?php echo $moduleId=="blogs"? "active":"" ?>" id="blogs">
			<ol class="breadcrumb">
			  <li class="active"><a href="#">Index</a></li>
			  <li><a href="#">My Blog</a></li>
			  <li><a href="#">Blog List</a></li>
			</ol>
		</div>
		<?php 
    		}
			else if($moduleId=="tuhome")
			{
		?>
		<div class="tab-pane <?php echo $moduleId=="tuhome"? "active":"" ?>" id="tuhome">
		 	<ol class="breadcrumb">
			  <li class="active"><a href="#">Index</a></li>
			  <li><a href="#">Clubs List</a></li>
			  <li><a href="#">My Clubs</a></li>
			  <li><a href="#">Join Clubs</a></li>
			  <li><a href="#">Clubs Finance</a></li>
			  <li><a href="#">Clubs Comments</a></li>
			  <li><a href="<?php echo Yii::app()->createUrl("tuhome/news/index") ?>">News</a></li>
			</ol>
		</div>
		<?php 
    		}
			else if($moduleId=="navigate")
			{
		?>
		<div class="tab-pane <?php echo $moduleId=="navigate"? "active":"" ?>" id="navigate">
		 	<ol class="breadcrumb">
			  <li class="active"><a href="#">Website</a></li>
			  <li><a href="#">Meeting Rooms</a></li>
			  <li><a href="#">Emails</a></li>
			  <li><a href="#">Lives</a></li>
			  <li><a href="#">Traffic</a></li>
			  <li><a href="#">Organization</a></li>
			</ol>
		</div>
		<?php 
    		}
			else if($moduleId=="my")
			{
		?>
		<div class="tab-pane <?php echo $moduleId=="my"? "active":"" ?>" id="navigate">
		 	<ol class="breadcrumb">
			  <li <?php echo $actionId=='index'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("my/default/index") ?>">Index</a></li>
			  <li <?php echo $actionId=='passwd'? 'class="active"':'' ?>><a href="<?php echo Yii::app()->createUrl("my/default/passwd") ?>">Change Password</a></li>
			</ol>
		</div>
		<?php 
    		}
    	?>
	</div>
  </div><!-- /.container-fluid -->
</nav>

<div class="container" style="background-color:#fff;padding-bottom:20px;">
	<?php echo $content; ?>
</div>

<div class="navbar navbar-default navbar-fixed-bottom text-center" style="background-image:none;background-color:#0066ff;color:#eee;">
	<div class="container" style="padding-top:10px;">
		Copyright &copy; Onelibrary<br>
		Website tech admin: bihong.he@onelibrary.com
  	</div>
</div>
</body>
</html>
