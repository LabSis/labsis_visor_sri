<!DOCTYPE html>
<html>
    <head>
        <?php require_once $TMPL_PATH . 'maquetado/head.tmpl.php'; ?>
        <link rel="stylesheet" href="<?php echo $CSS_PATH ?>index.css"/>
    </head>
    <body>
        <div id="div_loading"></div>
        <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
            <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Visor SRI</a>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <span class="navbar-text mr-4">
                    BETA
                </span>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 offset-sm-2 my-4">
                    <input class="form-control form-control-lg" type="text" id="txt_url" name="txt_url" placeholder="http://domain_to_analyze.com">                    
                </div>
                <div class="col-sm-1 my-4">
                    <button id="btn_analyze" class="btn btn-primary btn-lg">Analyze</button>
                </div>
            </div>
            <div class="row" id="div_result">

            </div>
        </div>
        <?php require_once $TMPL_PATH . 'maquetado/js.tmpl.php'; ?>
        <script src="<?php echo $WEB_PATH ?>js/index.js"></script>
    </body>
</html>
