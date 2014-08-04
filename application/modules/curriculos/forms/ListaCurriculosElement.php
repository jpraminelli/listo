<?php

class Curriculos_Form_ListaCurriculosElement extends Zend_Form_Element_Xhtml
{

    public $helper = 'formNote';
    private $_curriculos = null;

    public function __construct($lista)
    {
        parent::__construct('lista_curriculos');
        $this->_curriculos = $lista;
        $this->removeDecorator('Label');
        $this->setIgnore(true);
        $this->setValue($this->getHtml());
    }

    private function getHtml()
    {

        $html = '<div class="tabbable">';
        $html .= '  <ul class="nav nav-tabs">';
        $html .= '    <li class="active"><a id="link-lista-curriculos" href="#tab-lista-curriculos" data-toggle="tab">Lista de currículos</a></li>';
        $html .= '    <li><a id="link-adicionar-curriculos" href="#tab-adicionar-curriculos" data-toggle="tab">Adicionar currículos manualmente</a></li>';
        $html .= '  </ul>';
        $html .= '  <div class="tab-content">';
        $html .= '    <div id="tab-lista-curriculos" class="tab-pane active">';
        $html .= $this->getListaCurriculos();
        $html .= '    </div>';
        $html .= '    <div id="tab-adicionar-curriculos" class="tab-pane">';
        $html .= '    </div>';
        $html .= '  </div>';
        $html .= '</div>';
        return $html;
    }

    private function getListaCurriculos()
    {
        $html = '<table id="lista-curriculos" class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '  <tr>';
        $html .= '    <th>Pts</th>';
        $html .= '    <th>Nome</th>';
        $html .= '    <th class="hidden-phone">Nascimento</th>';
        $html .= '    <th class="hidden-phone">Última atualização</th>';
        $html .= '    <th>&nbsp;</th>';
        $html .= '  </tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($this->_curriculos as $curriculo) {
            $html .= '<tr id="lc_' . $curriculo->lc_id . '" class="c_' . $curriculo->id . '">';
            $html .= '  <input name="curriculos[' . $curriculo->lc_id . '][id]" value="' . $curriculo->lc_id . '" type="hidden" />';
            $html .= '  <input name="curriculos[' . $curriculo->lc_id . '][curriculo_id]" value="' . $curriculo->id . '" type="hidden" />';
            $html .= "  <td>$curriculo->pontuacao</td>";
            $html .= "  <td>$curriculo->nome</td>";
            $html .= "  <td class=\"hidden-phone\">{$curriculo->fmt_data_nascimento()}</td>";
            $html .= "  <td class=\"hidden-phone\">{$curriculo->fmt_dh_atualizacao()}</td>";
            $html .= '  <td>';
            $html .= '    <div class="btn-group" style="width: 80px">';
            $html .= '      <a class="btn btn-mini btn-primary btn_editar_curriculo" href="' . $curriculo->id . '">Editar</a>';
            $html .= '      <button class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
            $html .= '      <ul class="dropdown-menu">';
            $html .= '        <li><a title="Remover" href="' . $curriculo->lc_id . '" class="link-remover-curriculo">Remover</a></li>';
            $html .= '      </ul>';
            $html .= '    </div>';
            $html .= '  </td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        return $html;
    }

}
