<?php
/**
 * Customer Active Record
 * @author  <your-name-here>
 */
class Fornecedor extends TRecord
{
    const TABLENAME = 'fornecedores';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome_fantasia');
        parent::addAttribute('razao_social');
        parent::addAttribute('cnpj');
        parent::addAttribute('status');
    }
}
?>