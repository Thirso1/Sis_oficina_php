<?php
/**
 * Customer Active Record
 * @author  <your-name-here>
 */
class Contato_Fornecedor extends TRecord
{
    const TABLENAME = 'contato_fornecedor';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
         parent::__construct($id);
        parent::addAttribute('telefone_1');
        parent::addAttribute('telefone_2');
        parent::addAttribute('email');
        parent::addAttribute('site');
        parent::addAttribute('tipo_titular');
        parent::addAttribute('id_titular');
    }
}
?>