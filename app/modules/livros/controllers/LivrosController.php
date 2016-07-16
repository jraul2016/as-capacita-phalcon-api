<?php
namespace App\Livros\Controllers;

use App\Controllers\RESTController;
use App\Livros\Models\Livros;

Class LivrosController extends RESTController 
{
    //lista os livros
    public function getLivros() 
    {
    	try {
    		$query = new \Phalcon\Mvc\Model\Query\Builder();
            $query->addFrom('\App\Livros\Models\Livros', 'Livros')
     		->columns(
     		[
     			'Livros.idLivro',
     			'Livros.sTitulo',
     			'Livros.sAutor',
    		]
     		);
    		
            return $query->getQuery()->execute();
    	} catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    //pesquisa de livros
    public function getLivro($idLivro)
    {
    	try {
               $livro = (new Livros())->findFirst(
                    [
                        'conditions' => "idLivro = '$idLivro'",
                        'columns' => $this->partialFields,
                    ]
                );
               return $livro;
    	} catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    //adiciona um novo livro
    public function addLivro()
    {
    	try {
    		$livrosModel = new Livros();
            $livrosModel->sTitulo = $this->di->get('request')->getPost('sTitulo');
            $livrosModel->sAutor = $this->di->get('request')->getPost('sAutor');

            $livrosModel->saveDB();
            return $livrosModel;
    	} catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
        }

    }

    //edita o usuario
    public function editLivro($idLivro)
    {
    	try {
    		$put = $this->di->get('request')->getPut();
    		$livro = (new Livros())->findFirst($idLivro);
    		if (false === $livro) {
                    throw new \Exception("This record doesn't exist", 200);
                }

                $livro->sTitulo = isset($put['sTitulo']) ? $put['sTitulo'] : $livro->sTitulo;
                $livro->sAutor = isset($put['sAutor']) ? $put['sAutor'] : $livro->sAutor;

                $livro->saveDB();
    	} catch (Exception $e) {
    			throw new \Exception($e->getMessage(), $e->getCode());
    	}
    }

    //deleta o usuario
    public function deleteLivro($idLivro)
    {
    	try {
    		$livro = (new Livros())->findFirst($idLivro);

                if (false === $livro) {
                    throw new \Exception("This record doesn't exist", 200);
                }

                return ['success' => $livro->delete()];
    	} catch (Exception $e) {
    			throw new \Exception($e->getMessage(), $e->getCode());
    	}


    }

}