<?php
error_reporting('none');
require('libs/Serializer.php');

$serialiser = new Serializer();
$inFormats = $serialiser->inputFormats;
$outFormats = $serialiser->outputFormats;

if (!empty($_POST['data'])) {
    $data = $_POST['data'];
    try {
    $result = $serialiser->convert($data);
    } catch( Exception $ex) {
        $result = $ex->getMessage();
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DeveloperTools - Serializer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="kolemp">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="http://yandex.st/highlightjs/8.0/styles/default.min.css">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
  </head>

  <body>
      <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-inner">
              <div class="container">
                  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="brand" href="#">Dev tools</a>
                  <div class="nav-collapse collapse">
                      <ul class="nav">
                          <li class="active"><a href="#">Serializer</a></li>
                          <li><a href="#about">Array Editor</a></li>
                      </ul>
                  </div><!--/.nav-collapse -->
              </div>
          </div>
      </div>
      <a href="https://github.com/pkoltermann/PHPdevTools"><img style="position: absolute; top: 0; right: 0; border: 0; z-index: 1040;" src="https://camo.githubusercontent.com/652c5b9acfaddf3a9c326fa6bde407b87f7be0f4/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6f72616e67655f6666373630302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>
      <div class="container">

          <h1>Serializer</h1>
          <p>Allows to easily perform array serialization (also to json).</p>

      <form id="serializerForm" method="post">
          <div class="row-fluid">
              <label class="span2">From format</label>

              <select class="span2" name="data[from]">
                  <?php foreach ($inFormats as $format) : ?>
                      <option <?= (!empty($data['from']) && $data['from'] === $format) ? 'selected="selected"' : ''; ?>><?= $format ?></option>
                  <?php endforeach; ?>
              </select>
          </div>
          <div class="row-fluid">
              <label class="span2">To format</label>
              <select class="span2 lfloat" name="data[to]">
                  <?php foreach ($outFormats as $format) : ?>
                      <option <?= (!empty($data['to']) && $data['to'] === $format) ? 'selected="selected"' : ''; ?>><?= $format ?></option>
                  <?php endforeach; ?>
              </select>
              <div class="span1">
                  <input type="submit" class="btn" value="Go"/>
              </div>
          </div>
          <div class="row-fluid">
              <div class="span6">
                  <label>Data source</label>
                  <textarea class="data-source" name="data[source]"><?php echo (!empty($data['source'])) ? htmlspecialchars($data['source']) : ''; ?></textarea>
              </div>
              <div class="span6<?= !empty($error) ? ' error' : ''; ?>" >
                  <label>Data result</label>
                  <textarea class="data-result" ><?php echo!empty($result) ? $result : ''; ?></textarea>
              </div>
          </div>
      </form>

    </div> <!-- /container -->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> 
<!--    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
<script src="http://yandex.st/highlightjs/8.0/highlight.min.js"></script>-->

  </body>
</html>
