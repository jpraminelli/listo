<?php

/* noticias/admin/index */
class __TwigTemplate_1c494e8f6851ce32adebd6ee4eef505441a7b48e0299f00befd19cd9b437ac1c extends Twig_Template
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
        echo " - Notícias";
    }

    // line 14
    public function block_content($context, array $blocks = array())
    {
        // line 15
        echo "    <div class=\"row\">
        <div class=\"col-md-3\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                    <h3 class=\"panel-title\">Notícias <small>(";
        // line 19
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["quantidade"]) ? $context["quantidade"] : null)), "html", null, true);
        echo ")</small></h3>
                </div>
                <div class=\"panel-body\">
                    <span class=\"glyphicon glyphicon-plus\"></span>
                    <a href=\"";
        // line 23
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|noticias|form");
        echo "\" class=\"ink-button green push-right\">Nova notícia...</a>
                </div>
            </div>
            <form action=\"";
        // line 26
        echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|noticias");
        echo "\" method=\"get\" role=\"form\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        <h3 class=\"panel-title\">Procurar</h3>
                    </div>

                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            <label for=\"por\" class=\"control-label\">Por</label>
                            <input id=\"por\" name=\"por\" value=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "por"), "method"), "getValue", array(), "method"), "html", null, true);
        echo "\" class=\"form-control\">
                            <span class=\"help-block\">Age no campo Nome.</span>
                        </div>
                    </div>
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            <label for=\"visivel\" class=\"control-label\">Situação</label>
                            
                            <select id=\"visivel\" name=\"visivel\" class=\"form-control\">
                                <option value=\"all\" ";
        // line 44
        if (($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "all")) {
            echo "selected";
        }
        echo ">Todos</option>
                                <option value=\"true\" ";
        // line 45
        if ((($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "") || ($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "true"))) {
            echo "selected";
        }
        echo ">Visiveis</option>
                                <option value=\"false\" ";
        // line 46
        if (($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "get", array(0 => "visivel"), "method"), "getValue", array(), "method") == "false")) {
            echo "selected";
        }
        echo ">Não visiveis</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"panel-footer\">
                        <button id=\"procurar\" type=\"submit\" class=\"btn btn-info\">Procurar</button>
                        ";
        // line 52
        if ((isset($context["emPesquisa"]) ? $context["emPesquisa"] : null)) {
            // line 53
            echo "                            <a href=\"";
            echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|noticias");
            echo "\" class=\"btn btn-default\">Limpar pesquisa</a>
                        ";
        }
        // line 55
        echo "                    </div>
                </div>
            </form>
        </div>
        <div class=\"col-md-9\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                    <h3 class=\"panel-title\">";
        // line 62
        echo (isset($context["tituloGrid"]) ? $context["tituloGrid"] : null);
        echo "</h3>
                </div>
                <div class=\"panel-body\">
                    ";
        // line 65
        if (twig_length_filter($this->env, (isset($context["noticias"]) ? $context["noticias"] : null))) {
            // line 66
            echo "                        <table id=\"rotas\" class=\"table\">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th class=\"col-md-1\">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
            // line 74
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["noticias"]) ? $context["noticias"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["noticia"]) {
                // line 75
                echo "                                    <tr id=\"row_";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "getId", array(), "method"), "html", null, true);
                echo "\" ";
                if (($this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "isVisivel", array(), "method") != 1)) {
                    echo "class=\"text-muted\"";
                }
                echo ">
                                        <td><a href=\"";
                // line 76
                echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|noticias|form", array("id" => $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "getId", array(), "method")));
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "getTitulo", array(), "method"), "html", null, true);
                echo "</a></td>
                                        <td>

                                            <div class=\"dropdown\">
                                                <a data-toggle=\"dropdown\" class=\"btn btn-primary btn-xs\" href=\"javascript:void(0);\"><span class=\"glyphicon glyphicon-cog\"></span> <b class=\"caret\"></b></a>
                                                <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
                                                    <li><a href=\"";
                // line 82
                echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|noticias|form", array("id" => $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "getId", array(), "method")));
                echo "\"><span class=\"glyphicon glyphicon-edit\"></span> Editar</a></li>
                                                    ";
                // line 83
                if (((!(isset($context["protegido"]) ? $context["protegido"] : null)) && (!(isset($context["inserindo"]) ? $context["inserindo"] : null)))) {
                    // line 84
                    echo "                                                        <li><a href=\"";
                    echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|noticias|visivel", array("id" => $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "getId", array(), "method")));
                    echo "\" class=\"desativar\">";
                    if ($this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "isVisivel", array(), "method")) {
                        echo "<span class=\"glyphicon glyphicon-thumbs-down\"></span> Desa";
                    } else {
                        echo "<span class=\"glyphicon glyphicon-thumbs-up\"></span> A";
                    }
                    echo "tivar</a></a></li>
                                                        <li><a href=\"";
                    // line 85
                    echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("url")->__invoke("admin|noticias|excluir", array("id" => $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : null), "getId", array(), "method")));
                    echo "\" class=\"desativar\"><span class=\"glyphicon glyphicon-remove\"></span> Excluir</a></a></li>
                                                    ";
                }
                // line 87
                echo "                                                </ul>
                                            </div>

                                        </td>
                                    </tr>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['noticia'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 93
            echo "                            </tbody>
                        </table>
                    ";
        } else {
            // line 96
            echo "                        <span class=\"text-muted\">";
            echo twig_escape_filter($this->env, (isset($context["tituloVazio"]) ? $context["tituloVazio"] : null), "html", null, true);
            echo "</span>
                    ";
        }
        // line 98
        echo "                </div>
                ";
        // line 99
        if ((twig_length_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["noticias"]) ? $context["noticias"] : null), "getPages", array(), "method"), "pagesInRange")) > 1)) {
            // line 100
            echo "                    <div class=\"panel-footer\">
                        ";
            // line 101
            echo $this->env->getExtension("zfc-twig")->getRenderer()->plugin("paginationControl")->__invoke((isset($context["noticias"]) ? $context["noticias"] : null), "Sliding", "shift.partial.paginator", array("route" => "admin|noticias"));
            echo "
                    </div>
                ";
        }
        // line 104
        echo "            </div>
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

    // line 132
    public function block_inlineScript($context, array $blocks = array())
    {
        // line 133
        echo "    ";
        $this->displayParentBlock("inlineScript", $context, $blocks);
        echo "
    <script type=\"text/javascript\">
        \$(function() {

        ";
        // line 137
        if (((!(isset($context["protegido"]) ? $context["protegido"] : null)) && (!(isset($context["inserindo"]) ? $context["inserindo"] : null)))) {
            // line 138
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
        // line 149
        echo "                });
    </script>
";
    }

    public function getTemplateName()
    {
        return "noticias/admin/index";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  276 => 149,  263 => 138,  261 => 137,  253 => 133,  250 => 132,  223 => 104,  217 => 101,  214 => 100,  212 => 99,  209 => 98,  203 => 96,  198 => 93,  187 => 87,  182 => 85,  171 => 84,  169 => 83,  165 => 82,  154 => 76,  145 => 75,  141 => 74,  131 => 66,  129 => 65,  123 => 62,  114 => 55,  108 => 53,  106 => 52,  95 => 46,  89 => 45,  83 => 44,  71 => 35,  59 => 26,  53 => 23,  46 => 19,  40 => 15,  37 => 14,  30 => 9,);
    }
}
