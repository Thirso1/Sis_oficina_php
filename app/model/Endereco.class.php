<?php
/**
 * Endereco Active Record
 * @author  <Adilson>
 */
class Endereco extends TRecord
{
    const TABLENAME = 'enderecos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
		parent::addAttribute('id');
        parent::addAttribute('logradouro');
        parent::addAttribute('endereco');
        parent::addAttribute('numero');
        parent::addAttribute('complemento');
        parent::addAttribute('referencia');
		parent::addAttribute('bairro');
        parent::addAttribute('cidade');
        parent::addAttribute('uf');
        parent::addAttribute('cep');
        parent::addAttribute('tipo_titular');
		parent::addAttribute('id_titular');
    }
}
?>