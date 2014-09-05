<?php

/* layout/layout */
class __TwigTemplate_ceb638cf2f1e8b5dbac1362134e3467519ead2c2a9e42124e00206c1c36b678f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'inlineScript' => array($this, 'block_inlineScript'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"pt-br\">
    <head>
        <script type=\"text/javascript\">
            var pathroot = \"";
        // line 5
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud");
        echo "\";
        </script>    
        ";
        // line 7
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("headMeta")->__invoke();
        echo "  
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        ";
        // line 11
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("headTitle")->__invoke();
        echo "

        <!-- Bootstrap core CSS -->
        <link href=\"";
        // line 14
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/css/bootstrap.min.css");
        echo "\" rel=\"stylesheet\">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src=\"../../assets/js/ie8-responsive-file-warning.js\"></script><![endif]-->
        <script src=\"";
        // line 18
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/ie-emulation-modes-warning.js");
        echo "\"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
          <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
        <![endif]-->

        <!-- Custom styles for this template -->
        <link href=\"";
        // line 27
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/css/carousel.css");
        echo "\" rel=\"stylesheet\">
    </head>
    <!-- NAVBAR
    ================================================== -->
    <body>
        <div class=\"navbar-wrapper\">
            <div class=\"container\">

                <div class=\"navbar navbar-inverse navbar-static-top\" role=\"navigation\">
                    <div class=\"container\">
                        <div class=\"navbar-header\">
                            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                                <span class=\"sr-only\">Toggle navigation</span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                                <span class=\"icon-bar\"></span>
                            </button>
                            <a class=\"navbar-brand\" href=\"#\">Project name</a>
                        </div>
                        <div class=\"navbar-collapse collapse\">
                            <ul class=\"nav navbar-nav\">
                                <li class=\"active\"><a href=\"#\">Home</a></li>
                                <li><a href=\"#about\">About</a></li>
                                <li><a href=\"#contact\">Contact</a></li>
                                <li><a href=\"";
        // line 51
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("noticias");
        echo "\">Notícias</a></li>
                                <li class=\"dropdown\">
                                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Dropdown <span class=\"caret\"></span></a>
                                    <ul class=\"dropdown-menu\" role=\"menu\">
                                        <li><a href=\"#\">Action</a></li>
                                        <li><a href=\"#\">Another action</a></li>
                                        <li><a href=\"#\">Something else here</a></li>
                                        <li class=\"divider\"></li>
                                        <li class=\"dropdown-header\">Nav header</li>
                                        <li><a href=\"#\">Separated link</a></li>
                                        <li><a href=\"#\">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Carousel
        ================================================== -->
        <div id=\"myCarousel\" class=\"carousel slide\" data-ride=\"carousel\">
            <!-- Indicators -->
            <ol class=\"carousel-indicators\">
                <li data-target=\"#myCarousel\" data-slide-to=\"0\" class=\"active\"></li>
                <li data-target=\"#myCarousel\" data-slide-to=\"1\"></li>
                <li data-target=\"#myCarousel\" data-slide-to=\"2\"></li>
            </ol>
            <div class=\"carousel-inner\">
                <div class=\"item active\">
                    <center><img src=\"";
        // line 84
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/img/10257578_673016882767592_8918910219287179851_o.png");
        echo "\" alt=\"First slide\"></center>
                    <div class=\"container\">
                        <div class=\"carousel-caption\">
                            <h1>Example headline.</h1>
                            <p>Note: If you're viewing this page via a <code>file://</code> URL, the \"next\" and \"previous\" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
                            <p><a class=\"btn btn-lg btn-primary\" href=\"#\" role=\"button\">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class=\"item\">
                    <center><img src=\"";
        // line 94
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/img/10257578_673016882767592_8918910219287179851_o.png");
        echo "\" alt=\"First slide\"></center>
                    <div class=\"container\">
                        <div class=\"carousel-caption\">
                            <h1>Another example headline.</h1>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p><a class=\"btn btn-lg btn-primary\" href=\"#\" role=\"button\">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class=\"item\">
                     <center><img src=\"";
        // line 104
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/img/10257578_673016882767592_8918910219287179851_o.png");
        echo "\" alt=\"First slide\"></center>
                    <div class=\"container\">
                        <div class=\"carousel-caption\">
                            <h1>One more for good measure.</h1>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p><a class=\"btn btn-lg btn-primary\" href=\"#\" role=\"button\">Browse gallery</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class=\"left carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>
            <a class=\"right carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>
        </div><!-- /.carousel -->



        <!-- Marketing messaging and featurettes
        ================================================== -->
        <!-- Wrap the rest of the page in another container to center all the content. -->

        <div class=\"container marketing\">

            <div id=\"flash\">";
        // line 126
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("flash")->__invoke();
        echo "</div>
            ";
        // line 128
        echo "            ";
        $this->displayBlock('content', $context, $blocks);
        // line 129
        echo "
            <!-- FOOTER -->
            <footer>
                <p class=\"pull-right\"><a href=\"#\">Back to top</a></p>
                <p>&copy; 2014 Company, Inc. &middot; <a href=\"#\">Privacy</a> &middot; <a href=\"#\">Terms</a></p>
            </footer>

        </div><!-- /.container -->
    ";
        // line 137
        $this->displayBlock('inlineScript', $context, $blocks);
        // line 138
        echo "
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src=\"";
        // line 142
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/jquery-1.11.1.min.js");
        echo "\"></script>
    <script src=\"";
        // line 143
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/bootstrap.min.js");
        echo "\"></script>
    <script src=\"";
        // line 144
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/docs.min.js");
        echo "\"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src=\"";
        // line 146
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/ie10-viewport-bug-workaround.js");
        echo "\"></script>
</body>
</html>
";
    }

    // line 128
    public function block_content($context, array $blocks = array())
    {
        echo (isset($context["content"]) ? $context["content"] : null);
    }

    // line 137
    public function block_inlineScript($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/layout";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 137,  224 => 128,  216 => 146,  211 => 144,  207 => 143,  203 => 142,  197 => 138,  195 => 137,  185 => 129,  182 => 128,  178 => 126,  153 => 104,  140 => 94,  127 => 84,  91 => 51,  64 => 27,  52 => 18,  45 => 14,  39 => 11,  32 => 7,  27 => 5,  21 => 1,);
    }
}
