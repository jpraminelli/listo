<?php

/* application/index/index */
class __TwigTemplate_927356f184c83f90041ddfc572892add4dcce9288e3a185c3ae7f9791cb40af8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout/layout");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
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

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $this->displayParentBlock("title", $context, $blocks);
        echo " - Home";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    <h2>layout front-end</h2>
    <br><br><a href=\"";
        // line 7
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("noticias");
        echo "\">Página de notícias</a><br><br><br>
";
    }

    public function getTemplateName()
    {
        return "application/index/index";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 7,  39 => 6,  36 => 5,  29 => 3,);
    }
}
