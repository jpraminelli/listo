<?php

/* application/admin/index */
class __TwigTemplate_3a2ec82b9f8d96d6a4089725b1d59de25898fff141654f7b0d72d544f0e7ff2a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout/admin");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
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

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $this->displayParentBlock("title", $context, $blocks);
        echo " - Home";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "application/admin/index";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 5,  29 => 3,);
    }
}
