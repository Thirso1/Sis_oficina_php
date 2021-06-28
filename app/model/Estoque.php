<?php
/**
 * Estoque Active Record
 * @author  <your-name-here>
 */
class Estoque extends TRecord
{
    const TABLENAME = 'estoque';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('unid_venda');
        parent::addAttribute('estoque_min');
        parent::addAttribute('estoque_max');
        parent::addAttribute('estoque_atual');
		parent::addAttribute('localizacao');
        parent::addAttribute('pedido_em_endamento');
    }
}
?>