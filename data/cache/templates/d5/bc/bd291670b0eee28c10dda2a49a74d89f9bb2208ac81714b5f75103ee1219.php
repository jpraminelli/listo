<?php

/* usuarios/login/login */
class __TwigTemplate_d5bcbd291670b0eee28c10dda2a49a74d89f9bb2208ac81714b5f75103ee1219 extends Twig_Template
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
        echo "<html>
    <!DOCTYPE html>
<html lang=\"pt-br\">
    <head>
        <meta charset=\"utf-8\">
        <meta name=\"google-site-verification\" content=\"-p5kWsP3u8LWKAfKGitQH7h8dGiChlxA5A9vBco6WUI\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        ";
        // line 8
        $this->displayBlock('meta', $context, $blocks);
        // line 9
        echo "        <title>";
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link href=\"";
        // line 10
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/bootstrap/css/bootstrap.min.css");
        echo "\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">
        <link href=\"";
        // line 11
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/css/estilos.css");
        echo "\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">
        ";
        // line 12
        $this->displayBlock('style', $context, $blocks);
        // line 13
        echo "        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
            <script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>
        <![endif]-->
        <script type=\"text/javascript\" src=\"";
        // line 17
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/jquery/jquery-1.10.2.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 18
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/jquery/jquery-ui-1.10.4.custom.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 19
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/bootstrap/js/bootstrap.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 20
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/js/jquery.remoteform.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 21
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/js/jquery.maskedinput.min.js");
        echo "\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 22
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/adm/js/jquery.maskMoney.js");
        echo "\"></script>
        ";
        // line 23
        $this->displayBlock('headScript', $context, $blocks);
        // line 24
        echo "    </head>

    <body>
        ";
        // line 28
        echo "        ";
        // line 29
        echo "        ";
        // line 30
        echo "        ";
        $this->displayBlock('content', $context, $blocks);
        // line 64
        echo "
        ";
        // line 66
        echo "        ";
        // line 67
        echo "        ";
        // line 68
        echo "        ";
        $this->displayBlock('inlineScript', $context, $blocks);
        // line 78
        echo "    </body>
</html>
";
    }

    // line 8
    public function block_meta($context, array $blocks = array())
    {
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, twig_constant("APP_NAME"), "html", null, true);
    }

    // line 12
    public function block_style($context, array $blocks = array())
    {
    }

    // line 23
    public function block_headScript($context, array $blocks = array())
    {
    }

    // line 30
    public function block_content($context, array $blocks = array())
    {
        // line 31
        echo "            
            <div class=\"row\">
                <div class=\"col-md-4 col-md-offset-4\">
                    
                    <br><br><div id=\"flash\">";
        // line 35
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("flash")->__invoke();
        echo "</div><br><br>
                    
                    <form action=\"";
        // line 37
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("login");
        echo "\" method=\"post\" role=\"form\">
                        ";
        // line 38
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formHidden")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "validator"), "method"));
        echo "
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">Login</h3>
                            </div>
                            <div class=\"pagina-body\">
                                <div class=\"form-group\">
                                    <label for=\"usuario[login]\" class=\"control-label\">Usuário:</label>
                                    <input id=\"usuario[login]\" name=\"usuario[login]\" autocomplete=\"off\" class=\"form-control\" maxlength=\"50\">
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"usuario[senha]\" class=\"control-label\">Senha</label>
                                    <input id=\"usuario[senha]\" name=\"usuario[senha]\" type=\"password\" autocomplete=\"off\" class=\"form-control\" maxlength=\"50\">
                                </div>
                                <div class=\"form-group\">
                                    <button id=\"salvar\" type=\"submit\" class=\"btn btn-primary\">Entrar</button>
                                </div>
                            </div>
                            <div class=\"panel-footer\">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        ";
    }

    // line 68
    public function block_inlineScript($context, array $blocks = array())
    {
        // line 69
        echo "            
            <script type=\"text/javascript\">
                \$(function() {
                    \$('form').remoteform({
                        onOkForwardTo: '";
        // line 73
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke();
        echo "'
                    });
                });
            </script>
        ";
    }

    public function getTemplateName()
    {
        return "usuarios/login/login";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  189 => 73,  183 => 69,  180 => 68,  150 => 38,  146 => 37,  141 => 35,  135 => 31,  132 => 30,  127 => 23,  122 => 12,  116 => 9,  111 => 8,  105 => 78,  102 => 68,  100 => 67,  98 => 66,  95 => 64,  92 => 30,  90 => 29,  88 => 28,  83 => 24,  81 => 23,  77 => 22,  73 => 21,  69 => 20,  65 => 19,  61 => 18,  57 => 17,  51 => 13,  49 => 12,  45 => 11,  41 => 10,  36 => 9,  34 => 8,  25 => 1,);
    }
}
