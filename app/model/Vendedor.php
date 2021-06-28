<?php
/**
 * Vendedor Active Record
 * @author  <Adilson>
 */
class Vendedor extends TRecord
{
    const TABLENAME = 'vendedor';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
		parent::addAttribute('tipo_contato');
        parent::addAttribute('contato');
        parent::addAttribute('id_fornecedor');
    }
}
?>