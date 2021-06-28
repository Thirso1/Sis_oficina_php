   <?php
/**
 * Item Venda Active Record
 * @author  <your-name-here>
 */
class Itens_venda extends TRecord
{
    const TABLENAME = 'itens_venda';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('id_venda');
        parent::addAttribute('id_produto');
        parent::addAttribute('descricao');
        parent::addAttribute('marca');
		parent::addAttribute('valor_uni');
        parent::addAttribute('qtde');
		parent::addAttribute('desconto');
        parent::addAttribute('sub_total');
    }
}
?>
