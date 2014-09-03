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
        ";
        // line 4
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("headMeta")->__invoke();
        echo "
        <meta charset=\"utf-8\">
        <meta name=\"google-site-verification\" content=\"-p5kWsP3u8LWKAfKGitQH7h8dGiChlxA5A9vBco6WUI\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        ";
        // line 8
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("headTitle")->__invoke();
        echo "
        <link href=\"";
        // line 9
        echo twig_escape_filter($this->env, twig_constant("CSS_estilo"), "html", null, true);
        echo "\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
            <script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>
        <![endif]-->
        <script type=\"text/javascript\" src=\"";
        // line 15
        echo twig_escape_filter($this->env, twig_constant("JS_jquery"), "html", null, true);
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 16
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
        // line 24
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("flash")->__invoke();
        echo "</div>
                ";
        // line 26
        echo "                ";
        $this->displayBlock('content', $context, $blocks);
        // line 27
        echo "            </div>
        </div>
        <div id=\"footer\">
            <div class=\"container\">
                <p class=\"text-muted\">
                    <span><strong>";
        // line 32
        echo twig_escape_filter($this->env, twig_constant("APP_NAME"), "html", null, true);
        echo "</strong> - Rede Magic &copy; 2014</span>
                    <span class=\"pull-right\">v";
        // line 33
        echo twig_escape_filter($this->env, twig_constant("APP_VERSION"), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->env->getExtension('usedMemory')->twigUsedMemory(), "html", null, true);
        echo "</span>
                </p>
            </div>
        </div>

        ";
        // line 38
        $this->displayBlock('inlineScript', $context, $blocks);
        // line 39
        echo "    </body>
</html>
";
    }

    // line 26
    public function block_content($context, array $blocks = array())
    {
        echo (isset($context["content"]) ? $context["content"] : null);
    }

    // line 38
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
        return array (  103 => 38,  97 => 26,  91 => 39,  89 => 38,  79 => 33,  75 => 32,  68 => 27,  65 => 26,  61 => 24,  50 => 16,  46 => 15,  37 => 9,  33 => 8,  26 => 4,  21 => 1,);
    }
}
