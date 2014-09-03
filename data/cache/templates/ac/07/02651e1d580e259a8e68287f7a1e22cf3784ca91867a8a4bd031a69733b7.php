<?php

/* relatorios/admin/index */
class __TwigTemplate_ac0702651e1d580e259a8e68287f7a1e22cf3784ca91867a8a4bd031a69733b7 extends Twig_Template
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
        echo " - Relatórios";
    }

    // line 14
    public function block_content($context, array $blocks = array())
    {
        // line 15
        echo "    <div class=\"row\">

        <div class=\"col-md-12\">
            
            <h2>Relatórios - Geral</h2>
            
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                    <h3 class=\"panel-title\">Filtros</h3>
                </div>
                <div class=\"panel-body\">

                    <div class=\"row\">
                        <form method=\"get\">
                            
                            
                            <div class=\"col-md-4\">
                                <label for=\"por\" class=\"control-label\">Por</label>
                                <input id=\"por\" name=\"por\" value=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "por"), "method"), "getValue", array(), "method"), "html", null, true);
        echo "\" class=\"form-control\">
                            </div>
                            
                            <div class=\"col-md-2\">
                                <label for=\"visivel\" class=\"control-label\">Situação</label>

                                <select id=\"visivel\" name=\"visivel\" class=\"form-control\">
                                    <option value=\"all\" ";
        // line 40
        if (($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "all")) {
            echo "selected";
        }
        echo ">Todos</option>
                                    <option value=\"true\" ";
        // line 41
        if ((($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "") || ($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "true"))) {
            echo "selected";
        }
        echo ">Visiveis</option>
                                    <option value=\"false\" ";
        // line 42
        if (($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "false")) {
            echo "selected";
        }
        echo ">Não visiveis</option>
                                </select>
                            </div>
                            <div>
                                <label>&nbsp;</label><br>
                                <button id=\"procurar\" type=\"submit\" class=\"btn btn-info\">Filtrar</button>
                                ";
        // line 48
        if ((isset($context["emPesquisa"]) ? $context["emPesquisa"] : null)) {
            // line 49
            echo "                                    <a href=\"";
            echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|relatorios");
            echo "\" class=\"btn btn-default\">Limpar</a>
                                ";
        }
        // line 51
        echo "
                                <a href=\"";
        // line 52
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|relatorios");
        echo "?por=";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "por"), "method"), "getValue", array(), "method"), "html", null, true);
        echo "&visivel=";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method"), "html", null, true);
        echo "\" target=\"_blank\" class=\"btn btn-default\"  style=\"float:right; margin-right: 15px\">Exportar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
                <div class=\"panel\">

                    <div style=\"width:100%; overflow:auto; height: auto;\">
                        
                        ";
        // line 63
        if ((isset($context["emPesquisa"]) ? $context["emPesquisa"] : null)) {
            // line 64
            echo "                            <table id=\"rotas\" class=\"table table-bordered\">
                                <thead>
                                    <tr>
                                        <th class=\"col-md-9\">Título</th>
                                        <th class=\"col-md-2\" style=\"text-align: center\">Data</th>
                                        <th class=\"col-md-1\" style=\"text-align: center\">Visivel</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   ";
            // line 74
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["relatorio"]) ? $context["relatorio"] : null));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                echo "                                        

                                        <tr>
                                            <td><p>";
                // line 77
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "titulo"), "html", null, true);
                echo "</p></td>
                                            <td style=\"text-align: center\"><p>";
                // line 78
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "criacao"), "html", null, true);
                echo "</p></td>
                                            <td style=\"text-align: center\"><p>";
                // line 79
                if ($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "visivel")) {
                    echo "Sim";
                } else {
                    echo "Não";
                }
                echo "</p></td>
                                        </tr>
                                        
                                    ";
                $context['_iterated'] = true;
            }
            if (!$context['_iterated']) {
                // line 83
                echo "
                                        <tr>
                                            <td colspan=\"6\" align=\"center\"><br>
                                                <h4>Nenhum registro encontrado!</h4><br>
                                            </td>
                                        </tr>

                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 90
            echo " 
                                </tbody>
                            </table><br>
                        ";
        } else {
            // line 94
            echo "                            <br><br><h3 style=\"text-align:center\">Selecione um filtro para mostrar os resultados</h3><br><br><br>
                        ";
        }
        // line 96
        echo "                    </div>

                    <br>

                

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class=\"modal fade\" id=\"destativar\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
                    <h4 class=\"modal-title\" id=\"myModalLabel\">Atenção</h4>
                </div>
                <div class=\"modal-body\">
                    ...
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancelar</button>
                    <a href=\"\" class=\"btn btn-primary\">Continuar</a>
                </div>
            </div>
        </div>
    </div>

";
    }

    // line 130
    public function block_inlineScript($context, array $blocks = array())
    {
        // line 131
        echo "    ";
        $this->displayParentBlock("inlineScript", $context, $blocks);
        echo "
    <script type=\"text/javascript\">
        \$(function() {

        ";
        // line 135
        if (((!(isset($context["protegido"]) ? $context["protegido"] : null)) && (!(isset($context["inserindo"]) ? $context["inserindo"] : null)))) {
            // line 136
            echo "                \$('.desativar').click(function() {

                    situacao = \$(this).text();
                    situacao = situacao.toLowerCase();
                    \$('.modal-body').html(\"Deseja \" + situacao + \" este registro?\");
                    \$('.btn-primary').attr(\"href\", \$(this).attr('href'));
                    \$('#destativar').modal('toggle');
                    return false;

                });
        ";
        }
        // line 147
        echo "                });
    </script>
";
    }

    public function getTemplateName()
    {
        return "relatorios/admin/index";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  248 => 147,  235 => 136,  233 => 135,  225 => 131,  222 => 130,  189 => 96,  185 => 94,  179 => 90,  166 => 83,  153 => 79,  149 => 78,  145 => 77,  136 => 74,  124 => 64,  122 => 63,  104 => 52,  101 => 51,  95 => 49,  93 => 48,  82 => 42,  76 => 41,  70 => 40,  60 => 33,  40 => 15,  37 => 14,  30 => 9,);
    }
}
