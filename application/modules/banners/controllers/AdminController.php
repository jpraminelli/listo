<?php

class Banners_AdminController extends Lib_Controller_Crud {

    protected $_indexUrl = 'banners/admin';
    protected $_indexActionTitle = 'Administração de banner';
    protected $_formActionTitleNew = 'Novo banner';
    protected $_formActionTitleEdit = 'Editando banner';
    protected $_usarListaPaginada = true;
    protected $_modelClass = 'Banners_Model_DbTable_Banners';
    protected $_formClass = 'Banners_Form_Banner';
    protected $_formFilterClass = 'Banners_Form_Filtros';
    protected $_imagem = null;
    protected $_remover_imagem_atual = null;

    protected function afterSave(&$values) {
        
        /**
         * Upload da imagem
         */
        $fta = new Zend_File_Transfer_Adapter_Http ();
        if ($_FILES) {
            $file = $fta->getFileInfo('imagem');
        } else {
            $file = array('imagem' => array('name' => array()));
        }
        if ($file ['imagem']['name']) {
            $novo_nome = md5($values ['id']);

            $fta->addFilter('Rename', DIR_BANNERS . '/' . $novo_nome);

            if (is_file(DIR_BANNERS . '/' . $novo_nome))
                unlink(DIR_BANNERS . '/' . $novo_nome);

            $fta->receive();

        }
    }
    
    public function excluirAction() {
        $id = (int) $this->_getParam('id', 0);
        
         if (is_file(DIR_BANNERS . '/' . md5($id))){
             unlink(DIR_BANNERS . '/' . md5($id));
         }
        
        parent::excluirAction();
    }
    
    public function alterarOrdemAction(){
       $tb_banner = new Banners_Model_DbTable_Banners();
       $banner = $tb_banner->find((int)$_POST['id-banner'])->current();
       if($banner){
           $banner->ordem = (int)$_POST['ordem'];
           $banner->save();
           Lib_FlashMessage::success('Ordem Alterada com sucesso!');
           $this->_redirect('banners/admin');
       }
       else{
           Lib_FlashMessage::error('Banner não encontrado!');
           $this->_redirect('banners/admin');
       }
    }

}