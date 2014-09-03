<?php

/* layout/admin */
class __TwigTemplate_fa1b59fcf061adc19bf23cdc5b7916dac8017968537287cd28e19d6c34773eda extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'meta' => array($this, 'block_meta'),
            'title' => array($this, 'block_title'),
            'style' => array($this, 'block_style'),
            'headScript' => array($this, 'block_headScript'),
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
        <meta charset=\"utf-8\">
        <meta name=\"google-site-verification\" content=\"-p5kWsP3u8LWKAfKGitQH7h8dGiChlxA5A9vBco6WUI\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        ";
        // line 7
        $this->displayBlock('meta', $context, $blocks);
        // line 8
        echo "        <title>";
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link href=\"";
        // line 9
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/bootstrap/css/bootstrap.min.css");
        echo "\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">
        <link href=\"";
        // line 10
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/css/estilos.css");
        echo "\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">
        ";
        // line 11
        $this->displayBlock('style', $context, $blocks);
        // line 12
        echo "        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
            <script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>
        <![endif]-->
        <script type=\"text/javascript\" src=\"";
        // line 16
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/jquery/jquery-1.10.2.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 17
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/jquery/jquery-ui-1.10.4.custom.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 18
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/bootstrap/js/bootstrap.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 19
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/js/jquery.remoteform.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 20
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/js/jquery.maskedinput.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 21
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/js/jquery.maskMoney.js");
        echo "\"></script>
        ";
        // line 22
        $this->displayBlock('headScript', $context, $blocks);
        // line 23
        echo "    </head>
    <body class=\"";
        // line 24
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("bodyClass")->__invoke();
        echo "\">
        <div id=\"wrap\">
            <div class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">
                <div class=\"container\">
                    <span class=\"promocao\">Projeto padrão zf2</span>
                    ";
        // line 29
        echo $this->getAttribute($this->getAttribute($this->getAttribute($this->env->getExtension("zfc-twig")->getRenderer()->plugin("navigation")->__invoke("application.navigation"), "menu", array(), "method"), "setUlClass", array(0 => "nav navbar-nav"), "method"), "setPartial", array(0 => "shift.partial.bootstrap_menu"), "method");
        echo "
                </div>
            </div>
            <div class=\"container\">
                <div id=\"flash\">";
        // line 33
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("flash")->__invoke();
        echo "</div>
                ";
        // line 35
        echo "                ";
        $this->displayBlock('content', $context, $blocks);
        // line 36
        echo "            </div>
        </div>
        <div id=\"footer\">
            <div class=\"container\">
                <p class=\"text-muted\">
                    <span><strong>";
        // line 41
        echo twig_escape_filter($this->env, twig_constant("APP_NAME"), "html", null, true);
        echo "</strong> - Rede Magic &copy; 2014</span>
                    <span class=\"pull-right\"><strong>";
        // line 42
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("nomeUsuarioLogado")->__invoke();
        echo "</strong> - v";
        echo twig_escape_filter($this->env, twig_constant("APP_VERSION"), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->env->getExtension('usedMemory')->twigUsedMemory(), "html", null, true);
        echo "</span>
                </p>
            </div>
        </div>
        ";
        // line 46
        $this->displayBlock('inlineScript', $context, $blocks);
        // line 47
        echo "        ";
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("highlight")->__invoke();
        echo "

    </body>
</html>
";
    }

    // line 7
    public function block_meta($context, array $blocks = array())
    {
    }

    // line 8
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, twig_constant("APP_NAME"), "html", null, true);
    }

    // line 11
    public function block_style($context, array $blocks = array())
    {
    }

    // line 22
    public function block_headScript($context, array $blocks = array())
    {
    }

    // line 35
    public function block_content($context, array $blocks = array())
    {
        echo (isset($context["content"]) ? $context["content"] : null);
    }

    // line 46
    public function block_inlineScript($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/admin";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  168 => 46,  162 => 35,  157 => 22,  152 => 11,  146 => 8,  141 => 7,  131 => 47,  129 => 46,  118 => 42,  114 => 41,  107 => 36,  104 => 35,  100 => 33,  93 => 29,  85 => 24,  82 => 23,  80 => 22,  76 => 21,  72 => 20,  68 => 19,  64 => 18,  60 => 17,  56 => 16,  50 => 12,  48 => 11,  44 => 10,  40 => 9,  35 => 8,  33 => 7,  25 => 1,  36 => 5,  29 => 3,);
    }
}
