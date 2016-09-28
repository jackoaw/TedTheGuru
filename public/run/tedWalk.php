<?php define('BASE_URL','http://localhost/'); ?>

<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/nav.css"/>

<!doctype html>
<html lang="en-us">
  <head>
    <center>Take a walk as Ted, through the Forest of Enlightenment</center>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Unity WebGL Player | Teds Walk</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/run/TemplateData/style.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>public/run/TemplateData/favicon.ico" />
    <script src="<?php echo BASE_URL; ?>public/run/TemplateData/UnityProgress.js"></script>
  </head>
  <body class="template">
    <p class="header"><span>Unity WebGL Player | </span>Teds Walk</p>
    <div class="template-wrap clear">
      <canvas class="emscripten" id="canvas" oncontextmenu="event.preventDefault()" height="600px" width="960px"></canvas>
      <br>
      <div class="logo"></div>
      <div class="fullscreen"><img src="<?php echo BASE_URL; ?>public/run/TemplateData/fullscreen.png" width="38" height="38" alt="Fullscreen" title="Fullscreen" onclick="SetFullscreen(1);" /></div>
      <div class="title">Teds Walk</div>
    </div>
    <p class="footer">&laquo; created with <a href="http://unity3d.com/" title="Go to unity3d.com">Unity</a> &raquo;</p>
    <script type='text/javascript'>
  var Module = {
    TOTAL_MEMORY: 268435456,
    errorhandler: null,			// arguments: err, url, line. This function must return 'true' if the error is handled, otherwise 'false'
    compatibilitycheck: null,
    dataUrl: <?php echo json_encode(BASE_URL); ?> + "public/run/Compressed/Run.data",
    codeUrl: <?php echo json_encode(BASE_URL); ?> + "public/run/Compressed/Run.js",
    memUrl: <?php echo json_encode(BASE_URL); ?> + "public/run/Compressed/Run.mem",
  };
</script>
<script src="<?php echo BASE_URL; ?>public/run/Compressed/UnityLoader.js"></script>

  </body>
</html>
