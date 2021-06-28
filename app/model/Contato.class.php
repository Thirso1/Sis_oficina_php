<?php
/**
 * Customer Active Record
 * @author  <your-name-here>
 */
class Contato extends TRecord
{
    const TABLENAME = 'contatos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('tipo');
        parent::addAttribute('dado');
        parent::addAttribute('tipo_titular');
        parent::addAttribute('id_titular');
    }
}
?>