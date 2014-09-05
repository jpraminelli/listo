<?php

/* layout/internas */
class __TwigTemplate_69f30ea2a61236c467fd20a8b2eb0e812ecaf873b2720d8c31daaf171f895385 extends Twig_Template
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
        <meta charset=\"utf-8\">
        ";
        // line 8
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("headMeta")->__invoke();
        echo "  
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

        <!-- Custom styles for this template -->
        <link href=\"";
        // line 17
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/css/blog.css");
        echo "\" rel=\"stylesheet\">
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src=\"../../assets/js/ie8-responsive-file-warning.js\"></script><![endif]-->
        <script src=\"";
        // line 20
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/ie-emulation-modes-warning.js");
        echo "\"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
          <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
        <![endif]-->
    </head>

    <body>

        <div class=\"blog-masthead\">
            <div class=\"container\">
                <nav class=\"blog-nav\">
                    <a class=\"blog-nav-item\" href=\"";
        // line 34
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("front");
        echo "\">Home</a>
                    <a class=\"blog-nav-item\" href=\"#\">New features</a>
                    <a class=\"blog-nav-item\" href=\"#\">Press</a>
                    <a class=\"blog-nav-item\" href=\"#\">New hires</a>
                    <a class=\"blog-nav-item active\" href=\"";
        // line 38
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("noticias");
        echo "\">Notícias</a>
                    <a class=\"blog-nav-item\" href=\"#\">About</a>
                </nav>
            </div>
        </div>

        <div class=\"container\">
            
             <div id=\"flash\">";
        // line 46
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("flash")->__invoke();
        echo "</div>
            ";
        // line 48
        echo "            ";
        $this->displayBlock('content', $context, $blocks);
        // line 49
        echo "


        </div><!-- /.container -->

        <div class=\"blog-footer\">
            <p>Blog template built for <a href=\"http://getbootstrap.com\">Bootstrap</a> by <a href=\"https://twitter.com/mdo\">@mdo</a>.</p>
            <p>
                <a href=\"#\">Back to top</a>
            </p>
        </div>
    ";
        // line 60
        $this->displayBlock('inlineScript', $context, $blocks);
        // line 61
        echo "
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src=\"";
        // line 65
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/jquery-1.11.1.min.js");
        echo "\"></script>
        <script src=\"";
        // line 66
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/bootstrap.min.js");
        echo "\"></script>
        <script src=\"";
        // line 67
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/docs.min.js");
        echo "\"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src=\"";
        // line 69
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/cloud/assets/bootstrap-3.2.0-dist/js/ie10-viewport-bug-workaround.js");
        echo "\"></script>
    </body>
</html>
";
    }

    // line 48
    public function block_content($context, array $blocks = array())
    {
        echo (isset($context["content"]) ? $context["content"] : null);
    }

    // line 60
    public function block_inlineScript($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/internas";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  147 => 60,  141 => 48,  133 => 69,  128 => 67,  124 => 66,  120 => 65,  114 => 61,  112 => 60,  99 => 49,  96 => 48,  92 => 46,  81 => 38,  74 => 34,  57 => 20,  51 => 17,  45 => 14,  39 => 11,  33 => 8,  27 => 5,  21 => 1,);
    }
}
