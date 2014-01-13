<?php
 require_once '/var/www/ieducar/includes/bootstrap.php';
 $entityName = $GLOBALS['coreExt']['Config']->app->entity->name;
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel=stylesheet type='text/css' href='styles/reset.css' />
    <link rel=stylesheet type='text/css' href='styles/portabilis.css' />
  </head>

  <body>
    <div id="cabecalho" class="texto-normal">
      <div id="ccorpo">
        <p><a id="logo" href="javascript:updateFrame()"><span class="logoTJ">&nbsp;</span></a><span id="status"><span id="entidade"><?php echo $entityName; ?></span></span></p>
      </div>
    </div>
  </body>
  
	<script language="JavaScript"> 
		function updateFrame(){ 
			window.parent.frames[1].location="/intranet/index.php" 
		} 
	</script> 
  
</html>
