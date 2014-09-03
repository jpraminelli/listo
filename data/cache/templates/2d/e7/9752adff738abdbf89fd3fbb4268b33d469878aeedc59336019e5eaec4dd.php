<?php

/* usuarios/admin/form */
class __TwigTemplate_2de79752adff738abdbf89fd3fbb4268b33d469878aeedc59336019e5eaec4dd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout/admin");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'inlineScript' => array($this, 'block_inlineScript'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/admin";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
        $this->displayParentBlock("title", $context, $blocks);
        echo " - ";
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
    }

    // line 14
    public function block_content($context, array $blocks = array())
    {
        // line 15
        echo "<div class=\"row\">
    <div class=\"col-md-12\">
        <form action=\"";
        // line 17
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|usuarios|form");
        echo "\" method=\"post\" role=\"form\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                    <h3 class=\"panel-title\">";
        // line 20
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</h3>
                </div>
                <div class=\"panel-body\">
                    
                    ";
        // line 24
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formHidden")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "validator"), "method"));
        echo "
                    ";
        // line 25
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formHidden")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "id"), "method"));
        echo "                    
                    
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <div class=\"form-group\">
                                <label for=\"nome\" class=\"control-label\">Nome</label>
                                ";
        // line 31
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formText")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "nome"), "method"));
        echo "
                            </div>
                        </div>
                    </div>
                    
                    <div class=\"row\">
                        <div class=\"col-md-4\">
                            <div class=\"form-group\">
                                <label for=\"login\" class=\"control-label\">Login</label>
                                ";
        // line 40
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formText")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "login"), "method"));
        echo "
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <div class=\"form-group\">
                                <label for=\"senha\" class=\"control-label\">Senha</label>
                                ";
        // line 46
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formPassword")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "senha"), "method"));
        echo "
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <div class=\"form-group\">
                                <label for=\"senha2\" class=\"control-label\">Repetir a senha</label>
                                ";
        // line 52
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formPassword")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "senha2"), "method"));
        echo "
                            </div>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <div class=\"form-group\">
                                <div class=\"checkbox\">
                                    <label>
                                        ";
        // line 62
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formCheckbox")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"));
        echo "
                                        Este usuário está visível e pode logar-se no sistema.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                                        
                </div>
                <div class=\"panel-footer\">
                    <button id=\"salvar\" type=\"submit\" class=\"btn btn-primary\">Salvar</button>
                    <a href=\"";
        // line 73
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("backTo")->__invoke();
        echo "\" class=\"btn btn-default\">Cancelar</a>
                </div>
                
            </div>
        </form>
    </div>
</div>
";
    }

    // line 85
    public function block_inlineScript($context, array $blocks = array())
    {
        // line 86
        $this->displayParentBlock("inlineScript", $context, $blocks);
        echo "
<script type=\"text/javascript\">
    \$(function() {
        \$('form').remoteform({
            onOkForwardTo: '";
        // line 90
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("backTo")->__invoke();
        echo "'
        });
    });
</script>
";
    }

    public function getTemplateName()
    {
        return "usuarios/admin/form";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  150 => 90,  143 => 86,  140 => 85,  128 => 73,  114 => 62,  101 => 52,  92 => 46,  83 => 40,  71 => 31,  62 => 25,  58 => 24,  51 => 20,  45 => 17,  41 => 15,  38 => 14,  30 => 9,);
    }
}
