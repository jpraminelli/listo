<?php

/* noticias/cadastro/index */
class __TwigTemplate_3807864f0f51c0bdec27681b2407442f3e5c88fb8e6333bd38eee676b346feb7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout/layout");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'inlineScript' => array($this, 'block_inlineScript'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/layout";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
        $this->displayParentBlock("title", $context, $blocks);
        echo " - Notícias";
    }

    // line 14
    public function block_content($context, array $blocks = array())
    {
        // line 15
        echo "
    <div class=\"row\">
        <div class=\"col-md-12\">
            <form action=\"";
        // line 18
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("cadastro");
        echo "\" method=\"post\" role=\"form\">
                
                ";
        // line 20
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formHidden")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "validator"), "method"));
        echo "
                ";
        // line 21
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formHidden")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "id"), "method"));
        echo "
                
                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        <h3 class=\"panel-title\">";
        // line 25
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</h3>
                    </div>
                    <div class=\"panel-body\">
                        
                        <div class=\"row\">
                            <div class=\"col-md-12\">
                                <div class=\"form-group\">
                                    <label for=\"titulo\" class=\"control-label\">Título</label>
                                    ";
        // line 33
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formText")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "titulo"), "method"));
        echo "
                                </div>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-md-12\">
                                <div class=\"form-group\">
                                    <label for=\"chamada\" class=\"control-label\">Chamada</label>
                                    ";
        // line 41
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formTextarea")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "chamada"), "method"));
        echo "
                                </div>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-md-12\">
                                <div class=\"form-group\">
                                    <label for=\"descricao\" class=\"control-label\">Descrição</label>
                                    ";
        // line 49
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formTextarea")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "descricao"), "method"));
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
        // line 59
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formCheckbox")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"));
        echo "
                                            Este registro está visível.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div><br><br>
                                            
                        <div class=\"row\">
                            <div class=\"col-md-12\">
                                <div class=\"form-group\">
                                    <div class=\"checkbox\">
                                        ";
        // line 71
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formCaptcha")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "security"), "method"));
        echo " <br>
                                        ";
        // line 72
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formElementErrors")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "security"), "method"));
        echo " <br>
                                        ";
        // line 73
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("formHidden")->__invoke($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "captcha"), "method"));
        echo "
                                        <a href=\"#\" id=\"refreshcaptcha\">Caso não consiga visualizar a imagem clique aqui</a>
                                    </div>
                                </div>
                            </div>
                        </div><br><br>
                        
                    </div>
                    <div class=\"panel-footer\">
                        <button id=\"salvar\" type=\"submit\" class=\"btn btn-primary\">Salvar</button>
                        <a href=\"";
        // line 83
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("backTo")->__invoke();
        echo "\" class=\"btn btn-default\">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
";
    }

    // line 94
    public function block_inlineScript($context, array $blocks = array())
    {
        // line 95
        echo "    ";
        $this->displayParentBlock("inlineScript", $context, $blocks);
        echo "
    <script type=\"text/javascript\">
        \$(function() {
   
            \$('#refreshcaptcha').click(function() {
                \$.ajax({
                    url: '";
        // line 101
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("basePath")->__invoke("/gera-imagem");
        echo "',
                    dataType:'json',
                    success: function(data) {
                        \$('#security-image').attr('src',data.src);
                        \$('#security-hidden').attr('value',data.id);
                    }
                });
            });
            
            \$('form').remoteform({
                onOkForwardTo: '";
        // line 111
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("backTo")->__invoke();
        echo "',
                onGeneralError: function(){
                    \$('#refreshcaptcha').trigger('click');
                }
            });
        });
    </script>
";
    }

    public function getTemplateName()
    {
        return "noticias/cadastro/index";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  180 => 111,  167 => 101,  157 => 95,  154 => 94,  143 => 83,  130 => 73,  126 => 72,  122 => 71,  107 => 59,  94 => 49,  83 => 41,  72 => 33,  61 => 25,  54 => 21,  50 => 20,  45 => 18,  40 => 15,  37 => 14,  30 => 9,);
    }
}
