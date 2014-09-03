<?php

/* layout/front */
class __TwigTemplate_9f3fbf7abad8d2c9b29a8c2f01feb18f566ab98166b67ce0cdbf2faeb3ecb8e1 extends Twig_Template
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
        <meta charset=\"utf-8\">
        <meta name=\"google-site-verification\" content=\"-p5kWsP3u8LWKAfKGitQH7h8dGiChlxA5A9vBco6WUI\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>";
        // line 7
        echo twig_escape_filter($this->env, twig_constant("APP_NAME"), "html", null, true);
        echo " - Login</title>
        <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, twig_constant("CSS_estilo"), "html", null, true);
        echo "\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
            <script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>
        <![endif]-->
        <script type=\"text/javascript\" src=\"";
        // line 14
        echo twig_escape_filter($this->env, twig_constant("JS_jquery"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 15
        echo twig_escape_filter($this->env, twig_constant("JS_jquery_remoteform"), "html", null, true);
        echo "\"></script>
    </head>
    <body class=\"pagina-login\">
        <div id=\"wrap\">
            <div class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">
                <div class=\"container\">Projeto padrão zf2</div>
            </div>
            <div class=\"container\">
                <div id=\"flash\">";
        // line 23
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("flash")->__invoke();
        echo "</div>
                ";
        // line 25
        echo "                ";
        $this->displayBlock('content', $context, $blocks);
        // line 26
        echo "            </div>
        </div>
        <div id=\"footer\">
            <div class=\"container\">
                <p class=\"text-muted\">
                    <span><strong>";
        // line 31
        echo twig_escape_filter($this->env, twig_constant("APP_NAME"), "html", null, true);
        echo "</strong> - Rede Magic &copy; 2014</span>
                    <span class=\"pull-right\">v";
        // line 32
        echo twig_escape_filter($this->env, twig_constant("APP_VERSION"), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->env->getExtension('usedMemory')->twigUsedMemory(), "html", null, true);
        echo "</span>
                </p>
            </div>
        </div>

        ";
        // line 37
        $this->displayBlock('inlineScript', $context, $blocks);
        // line 38
        echo "    </body>
</html>
";
    }

    // line 25
    public function block_content($context, array $blocks = array())
    {
        echo (isset($context["content"]) ? $context["content"] : null);
    }

    // line 37
    public function block_inlineScript($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/front";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  99 => 37,  93 => 25,  87 => 38,  85 => 37,  75 => 32,  71 => 31,  64 => 26,  61 => 25,  57 => 23,  46 => 15,  42 => 14,  33 => 8,  21 => 1,  39 => 6,  36 => 5,  29 => 7,);
    }
}
