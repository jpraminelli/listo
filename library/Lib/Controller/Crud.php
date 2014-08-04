<?php

class Lib_Controller_Crud extends Zend_Controller_Action
{

    protected $_session = null;
    protected $_modelClass = null;
    protected $_record = null;
    protected $_indexUrl = null;
    protected $_backUrl = null;
    protected $_formClass = null;
    protected $_formFilterClass = null;
    protected $_listaPaginada = true;
    protected $_indexActionTitle = null;
    protected $_formActionTitleNew = null;
    protected $_formActionTitleEdit = null;
    protected $_model = null;
    protected $_useTransaction = true;
    protected $_useFlashMessages = true;
    protected $_filterClass = false;
    protected $_desktopPageRange = 11;
    protected $_mobilePageRange = 3;
    protected $_desktopCountPerPage = 15;
    protected $_mobileCountPerPage = 15;

    public function init()
    {
        $this->_session = Lib_Session_Namespace::instance();
        $this->_model = new $this->_modelClass();
        $this->view->pageUrl = $this->_indexUrl;
        $this->initBackUrl();
        $this->view->backUrl = $this->_backUrl;
    }

    public function indexAction()
    {
        // O index sempre redefine o backUrl
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']) {
            $this->_backUrl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        } else {
            $this->_backUrl = WWWROOT;
        }
        if (!is_array($this->_session->backUrl)) {
            $this->_session->backUrl = array();
        }
        $class = get_class($this);
        $this->_session->backUrl[$class] = $this->_backUrl;
        $this->view->backUrl = $this->_backUrl;
        //
        $this->beforeIndex();
        $filtros = array();
        if ($this->_formFilterClass) {
            $formFilter = new $this->_formFilterClass();
            $formFilter->populate($_GET);
//            $formFilter->isValid($_GET);
            $filtros = $formFilter->getValues();
            $this->view->formFilter = $formFilter;
        } else {
            $this->view->formFilter = null;
        }
        $this->_title($this->_indexActionTitle);
        if ($this->_listaPaginada === true) {
            if (isset($filtros['pagina'])) {
                $pagina = (int) $filtros['pagina'];
            } else {
                $pagina = 1;
            }
            $lista = $this->_model->listaPaginada($filtros);
            if (!IS_MOBILE) {
                $lista->setItemCountPerPage($this->_desktopCountPerPage);
                $lista->setPageRange($this->_desktopPageRange);
            } else {
                $lista->setItemCountPerPage($this->_mobileCountPerPage);
                $lista->setPageRange($this->_mobilePageRange);
            }
            $lista->setCurrentPageNumber($pagina);
        } else {
            $lista = $this->_model->lista($filtros);
        }
        $this->view->filtros = $filtros;
        $this->view->lista = $lista;
        $this->view->novoRegistro = isset($this->_formActionTitleNew) ? $this->_formActionTitleNew : 'Novo registro';
        $this->afterIndex();
    }

    public function formAction()
    {
        $form = null;
        $id = (int) $this->_getParam('id', 0);
        if (!$this->_request->isPost()) {
            // GET
            if ($id > 0) {
                $this->_record = $this->_model->find($id)->current();
                if (!$this->_record) {
                    if ($this->_useFlashMessages) {
                        Lib_FlashMessage::error('Registro inexistente.');
                    }
                    $this->_redirect($this->_backUrl);
                }
                $recordArray = $this->_record->toArray();
                $this->afterFind($recordArray);
                $form = new $this->_formClass($recordArray, $this->_record, $this->_backUrl);
                $form->populate($recordArray);
                $this->_title($this->_formActionTitleEdit);
            } else {
                $form = new $this->_formClass(null, null, $this->_backUrl);
                $this->_title($this->_formActionTitleNew);
            }
            //pe($recordArray);
            $this->view->form = $form;
        } else {
            // POST
            try {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
                $_POST['id'] = $id;
                $this->beforeValidate($_POST);
                $form = new $this->_formClass($_POST);
                if ($form->isValid($_POST)) {
                    if ($this->_useTransaction) {
                        Zend_Db_Table::getDefaultAdapter()->beginTransaction();
                    }
                    $values = $form->getValues();
                    if ($id == 0) {
                        $this->beforeInsert($values);
                        $this->beforeSave($values);
                        if (isset($values['id'])) {
                            unset($values['id']);
                        }
                        $id = $this->_model->insert($values);
                        if ($id) {
                            $values['id'] = $id;
                            $this->afterInsert($values);
                            $this->afterSave($values);
                            Lib_UploadArea::removeDir();
                            if ($this->_useTransaction) {
                                Zend_Db_Table::getDefaultAdapter()->commit();
                            }
                            if ($this->_useFlashMessages) {
                                Lib_FlashMessage::success('Cadastro realizado com sucesso.');
                            }
                            echo Lib_Form_Ajax_Response::ok();
                            return;
                        }
                    } else {
                        $values['id'] = $id;
                        $this->beforeUpdate($values);
                        $this->beforeSave($values);
                        $update = $this->_model->update($values, "id = $id");
                        if ($update) {
                            $this->afterUpdate($values);
                            $this->afterSave($values);
                            Lib_UploadArea::removeDir();
                            if ($this->_useTransaction) {
                                Zend_Db_Table::getDefaultAdapter()->commit();
                            }
                            if ($this->_useFlashMessages) {
                                Lib_FlashMessage::success('Alteração realizada com sucesso.');
                            }
                            echo Lib_Form_Ajax_Response::ok();
                            return;
                        }
                    }
                    if ($this->_useTransaction) {
                        Zend_Db_Table::getDefaultAdapter()->rollBack();
                    }
                    Lib_UploadArea::removeDir();
                    echo Lib_Form_Ajax_Response::generalError('Não foi possível realizar a operação. Por favor, tente novamente.');
                    return;
                } else {
//                    pe($form->getErrors());
                    Lib_UploadArea::removeDir();
                    echo Lib_Form_Ajax_Response::fillError($form);
                    return;
                }
            } catch (Exception $e) {
                if ($this->_useTransaction) {
                    Zend_Db_Table::getDefaultAdapter()->rollBack();
                }
                Lib_Logger::instance()->log($e->getTraceAsString(), Zend_Log::ERR);
                if (APPLICATION_ENV == 'production') {
                    echo Lib_Form_Ajax_Response::generalError('Não foi possível realizar a operação. Por favor, entre em contato com o suporte.');
                } else {
                    throw $e;
                }
                return;
            }
        }
    }

    public function excluirAction()
    {
        $id = (int) $this->_getParam('id', 0);
        $reg = $this->_model->find($id)->current();
        if ($reg) {
            if ($this->_useTransaction) {
                Zend_Db_Table::getDefaultAdapter()->beginTransaction();
            }
            try {
                $this->beforeDelete($id);
                $reg->delete();
                if ($this->_useTransaction) {
                    Zend_Db_Table::getDefaultAdapter()->commit();
                }
                if ($this->_useFlashMessages) {
                    Lib_FlashMessage::success('Registro excluído com sucesso!');
                }
            } catch (Exception $e) {
                if (APPLICATION_ENV == 'production') {
                    if ($this->_useFlashMessages) {
                        Lib_FlashMessage::error('Ocorreu um erro. Por favor, tente novamente em alguns instantes.<!--' . $e->getMessage() . '-->');
                    }
                } else {
                    Lib_FlashMessage::error('Ocorreu um erro: ' . $e->getMessage() . '<br />' . $e->getTraceAsString());
                }
                if ($this->_useTransaction) {
                    Zend_Db_Table::getDefaultAdapter()->rollBack();
                }
            }
        } else {
            if ($this->_useFlashMessages) {
                Lib_FlashMessage::info('Registro não encontrado!');
            }
        }
        $this->_redirect($this->_backUrl);
    }

    public function ativarDesativarAction()
    {
        $id = (int) $this->_getParam('id', '0');
        $reg = $this->_model->find($id)->current();
        // Identifica o gênero da tabela
        try {
            $reg->ativo;
            $coluna = 'ativo';
        } catch (Zend_Db_Table_Row_Exception $e) {
            $coluna = 'ativa';
        }
        if ($reg) {
            $db = $this->_model->getAdapter();
            $db->beginTransaction();
            try {
                $reg->{$coluna} = $reg->{$coluna} > 0 ? 0 : 1;
                $reg->save();
                $db->commit();
                if ($this->_useFlashMessages) {
                    Lib_FlashMessage::success('Registro ' . ($reg->{$coluna} > 0 ? '' : 'des' ) . 'ativado com sucesso!');
                }
            } catch (Exception $e) {
                $db->rollBack();
                if (APPLICATION_ENV == 'production') {
                    if ($this->_useFlashMessages) {
                        Lib_FlashMessage::error('Ocorreu um erro. Por favor, tente novamente em alguns instantes.<!--' . $e->getMessage() . '-->');
                    }
                } else {
                    Lib_FlashMessage::error('Ocorreu um erro: ' . $e->getMessage() . '<br />' . $e->getTraceAsString());
                }
            }
        } else {
            if ($this->_useFlashMessages) {
                Lib_FlashMessage::info('Registro não encontrado!');
            }
        }
        $this->_redirect($this->_backUrl);
    }

    protected function initBackUrl()
    {
        $class = get_class($this);
        if (is_array($this->_session->backUrl) && (isset($this->_session->backUrl[$class]))) {
            $this->_backUrl = $this->_session->backUrl[$class];
        } else {
            $this->_backUrl = WWWROOT . 'admin';
        }
    }

    /**
     * Evento para validar e filtrar o $_POST na listagem
     */
//    protected function postIndex(&$values)
//    {
//        $form = clone $this->view->form_filtro;
//        if ($form->isValid($values)) {
//            $form->populate($values);
//        } else {
//            foreach ($form->getMessages() as $field => $errors) {
//                Lib_FlashMessage::info($form->getElement($field)->getLabel() . ': ' . implode(' ', $errors));
//            }
//            $values = $form->getValidValues($values);
//        }
//    }

    /**
     * Evento executado antes do processamento da listagem.
     */
    protected function beforeIndex()
    {
        
    }

    /**
     * Evento executado após o processamento da listagem.
     */
    protected function afterIndex()
    {
        
    }

    /**
     * Evento executado antes de excluir o registro. Este é o ponto onde as dependências deverão ser excluídas.
     */
    protected function beforeDelete($id)
    {
        
    }

    /**
     * Evento executado após encontrar o registro para alteração.
     */
    protected function afterFind(&$values)
    {
        
    }

    /**
     * Evento executado antes da validação realizada pelo form.
     */
    protected function beforeValidate(&$values)
    {
        
    }

    /**
     * Evento executado antes do insert ou update do objeto no banco de dados.
     */
    protected function beforeSave(&$values)
    {
        
    }

    /**
     * Evento executado depois do insert ou update do objeto no banco de dados.
     */
    protected function afterSave(&$values)
    {
        
    }

    /**
     * Evento executado antes do insert do objeto no banco de dados.
     */
    protected function beforeInsert(&$values)
    {
        
    }

    /**
     * Evento executado depois do insert do objeto no banco de dados.
     */
    protected function afterInsert(&$values)
    {
        
    }

    /**
     * Evento executado antes do update do objeto no banco de dados.
     */
    protected function beforeUpdate(&$values)
    {
        
    }

    /**
     * Evento executado depois do update do objeto no banco de dados.
     */
    protected function afterUpdate(&$values)
    {
        
    }

    protected function _title($title)
    {
        $this->view->headTitle()
            ->prepend($title);
        $this->view->pageTitle = $title;
    }

}