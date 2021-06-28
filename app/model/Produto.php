<?php
/**
 * Produto Active Record
 * @author  <your-name-here>
 */
class Produto extends TRecord
{
    const TABLENAME = 'produtos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('descricao');
        parent::addAttribute('marca');
        parent::addAttribute('cod_marca');
        parent::addAttribute('preco_custo');
		parent::addAttribute('preco_venda');
        parent::addAttribute('margem_lucro');
        parent::addAttribute('desconto');
		parent::addAttribute('imagem');
        parent::addAttribute('id_categoria');
        parent::addAttribute('status');
    }
}
?>