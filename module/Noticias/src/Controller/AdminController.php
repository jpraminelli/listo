<?php

namespace Noticias\Controller;

use Shift\SM;
use Noticias\Entity\Noticia;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class AdminController extends AbstractActionController
{
    private $noticiasService;

    public function __construct()
    {
        $this->noticiasService = SM::get('noticias.service.noticias');
    }

    public function indexAction()
    {

        $emPesquisa = $this->emPesquisa();
        
        $noticias = $this->noticiasService->collection($this->params()->fromQuery(), $this->params()->fromRoute('pagina', 1));
        
        $form = SM::get('noticias.form.noticia_search');
        $form->setData($this->params()->fromQuery());
        
        return array(
            'emPesquisa' => $emPesquisa,
            'tituloGrid' => ($emPesquisa) ? 'Resultado da pesquisa' : 'Todos os registros',
            'quantidade' => $this->noticiasService->count(),
            'form' => $form,
            'noticias' => $noticias,
        );
    }

    public function formAction()
    {   
        $noticia = new Noticia();
        $form = SM::get('noticias.form.noticia');
        
        if ($this->request->isGet()) {
            $id = (int) $this->params('id');
        } else {
            $id = (int) $this->request->getPost()->id;
        }
        
        if ($id) {
            $noticia = $this->noticiasService->get($id);
            $title = "Editando {$noticia->getTitulo()}";
        } else {
            $title = 'Nova notícia';
        }

        $form->bind($noticia);
        
        if ($this->request->isPost()) {
            
            $retorno = array();
            
            // seta os filtros para validacao do form
            $form->setInputFilter($noticia->getInputFilter());

            // seta os campos que deve ser validados
            $form->setValidationGroup('id', 'titulo', 'chamada', 'descricao', 'visivel', 'validator');

            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                
                $this->noticiasService->save($noticia);
                $this->flash()->success('Operação realizada com sucesso.');
                $this->highlight("tr#row_{$noticia->getId()}");
                $retorno['code'] = 'OK';
            } else {
                $retorno['code'] = 'ERROR';
                $retorno['errors'] = $form->getMessages();
                $retorno['flashError'] = 'Um ou mais erros impedem a gravação dos dados.';
            }
            return new JsonModel($retorno);
        }
        $form->prepare();
        
        return array(
            'title' => $title,
            'form' => $form,
            'noticia' => $noticia,
        );
    }

    public function visivelAction(){

        $id = (int) $this->params('id');
        $noticia = $this->noticiasService->get($id);
        
        if(!$noticia->getId()){
            $this->flash()->error('Erro: registro não encontrado.');
            return $this->redirect()->toRoute('noticias');
        }
        
        // verifica se está ativo
        if($noticia->isVisivel() == 1){
            $noticia->setVisivel(0);
        } else {
            $noticia->setVisivel(1);
        }

        $this->noticiasService->save($noticia);
        $this->flash()->success('Operação realizada com sucesso.');

        return $this->redirect()->toRoute('noticias');

    }
    
    public function excluirAction(){

        $id = (int) $this->params('id');
        $noticia = $this->noticiasService->get($id);
        
        if(!$noticia->getId()){
            $this->flash()->error('Erro: registro não encontrado!');
            return $this->redirect()->toRoute('noticias');
        }

        $this->noticiasService->excluir($noticia);
        $this->flash()->success('Operação realizada com sucesso.');

        return $this->redirect()->toRoute('noticias');

    }

    private function emPesquisa()
    {
        foreach ($this->params()->fromQuery() as $key => $value) {
            if ($value != '') {
                return true;
            }
        }
        return false;
    }

}
