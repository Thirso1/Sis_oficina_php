<?php
/**
 * Customer Active Record
 * @author  <your-name-here>
 */
class Cliente extends TRecord
{
    const TABLENAME = 'clientes';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('rg_ie');
        parent::addAttribute('cpf_cnpj');
        parent::addAttribute('status');
    }
}
?>