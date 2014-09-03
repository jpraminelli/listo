<?php

/* noticias/noticias/index */
class __TwigTemplate_9f3626b717782d30cebdcea17f44a81412dd667aaab4471cd2b06694dcf79520 extends Twig_Template
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
        echo "    <h1>Página de notícias</h1>
    
    ";
        // line 17
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["noticias"]) ? $context["noticias"] : null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["noticia"]) {
            // line 18
            echo "        
        <p>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "titulo"), "html", null, true);
            echo "</p>
        <p>";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "descricao"), "html", null, true);
            echo "</p>
        <hr>
        
    ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 24
            echo "        <p>Nenhuma notícia encontrada!</p>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['noticia'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 31
    public function block_inlineScript($context, array $blocks = array())
    {
        // line 32
        echo "    ";
        $this->displayParentBlock("inlineScript", $context, $blocks);
        echo "
";
    }

    public function getTemplateName()
    {
        return "noticias/noticias/index";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 32,  74 => 31,  65 => 24,  56 => 20,  52 => 19,  49 => 18,  44 => 17,  40 => 15,  37 => 14,  30 => 9,);
    }
}
