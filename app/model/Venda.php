   <?php
/**
 * Venda Active Record
 * @author  <your-name-here>
 */
class Venda extends TRecord
{
    const TABLENAME = 'Venda';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('data_hora');
        parent::addAttribute('valor_total');
        parent::addAttribute('desconto');
        parent::addAttribute('status');
		parent::addAttribute('id_usuario');
        parent::addAttribute('id_cliente');
    }
}
?>
