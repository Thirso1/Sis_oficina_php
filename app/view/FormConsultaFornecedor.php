<?php
/**
 * DatagridCustomView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FormConsultaFornecedor  extends TPage
{
    private $datagrid;
    
    public function __construct()
    {
        parent::__construct();
        $action = new TAction( ['FormCadastroFornecedor', 'onEdit' ] );
        //$action->setParameter('key', 0);
		$b2 = new TActionLink('Novo', $action, 'white', 10, '', 'far:check-square #FEFF00');
        $b2->class='btn btn-success';
		
        // creates one datagrid
        $this->datagrid = new TDataGrid;
        //$this->datagrid->enablePopover('Details', '<b>Cód:</b> {id} <br> <b>Nome:</b> {nome} <br> <b>CPF/CNPJ:</b> {cpf_cnpj}');
        
        // create the datagrid columns
        $id                 = new TDataGridColumn('id',    'Cód',    'center', '10%');
        $nome_fantasia      = new TDataGridColumn('nome_fantasia',    'Nome',    'left',   '30%');
        $cnpj               = new TDataGridColumn('cnpj',    'CNPJ',    'left',   '30%');
       
        
        // add the columns to the datagrid, with actions on column titles, passing parameters
        $this->datagrid->addColumn($id );
        $this->datagrid->addColumn($nome_fantasia);
        $this->datagrid->addColumn($cnpj);
        
        // creates two datagrid actions
        $action1 = new TDataGridAction(['FormCadastroFornecedor', 'onEdit'],   ['id'=>'{id}',  'nome_fantasia' => '{nome_fantasia}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['id'=>'{id}'] );
		
        // add the actions to the datagrid
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // creates the datagrid model
        $this->datagrid->createModel();
		
		// search box
        $input_search = new TEntry('input_search');
        $input_search->placeholder = _t('Search');
        $input_search->setSize('100%');
        
        // enable fuse search by column name
        $this->datagrid->enableSearch($input_search, 'nome_fantasia, cnpj');
		
		$panel = new TPanelGroup( _t('Datagrid search') );
        $panel->addHeaderWidget($input_search);
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
		$vbox->add($b2); 
		$vbox->add($panel);
        $vbox->add(TPanelGroup::pack(_t('Native datagrid'), $this->datagrid));

        parent::add($vbox);
    }
    
    /**
     * Load the data into the datagrid
     */
    function onReload()
    {
        $this->datagrid->clear();
        
		TTransaction::open('connect'); // open transaction 
		$repository = new TRepository('Fornecedor');
		$fornecedores = $repository->load();
		TTransaction::close(); // Closes the transaction 			

		foreach($fornecedores as $fornecedor)
		{
			// add an regular object to the datagrid
			$item = new StdClass;
			$item->id   = $fornecedor->id;
			$item->nome_fantasia   = $fornecedor->nome_fantasia;
			$item->cnpj   = $fornecedor->cnpj;
			$this->datagrid->addItem($item);
		}		
		
    }
    
    /**
     * Executed when the user clicks at the view button
     */
    public function onView($param)
    {
        // get the parameter and shows the message
        $id = $param['id'];
        $nome = $param['nome'];
        new TMessage('info', "The code is: <b>$id</b> <br> The name is : <b>$nome</b>");
    }
    
    /**
     * Executed when the user clicks at the delete button
     * STATIC Method, does't reload the page when executed
     */
    public static function onDelete($param)
    {
        // get the parameter and shows the message
        $id = $param['id'];
        new TMessage('error', "The register <b>{$id}</b> may not be deleted");
    }
    
    /**
     * shows the page
     */
    function show()
    {
        $this->onReload();
        parent::show();
    }
}