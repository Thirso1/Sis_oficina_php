<?php
/**
 * CustomerForm Form
 * @author  <your name here>
 */
class FormCadastroPropriedade extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */

    public function __construct( $param )
    {
        parent::__construct();        
		
        // creates the form
        $this->form = new BootstrapFormBuilder('form_propriedade');
        $this->form->setFormTitle('Propriedade');
		
        // create the form fields
        $id = new TEntry('id');

        $nome = new TEntry('nome');
        $rg_ie = new TEntry('rg_ie');
        $cpf_cnpj = new TEntry('cpf_cnpj');
        $status = new TCombo('status');
        $logradouro = new TCombo('logradouro');
        $endereco = new TEntry('endereco');
        $numero = new TEntry('numero');
        $complemento = new TEntry('complemento');
        $referencia = new TEntry('referencia');
        $bairro = new TEntry('bairro');
        $cidade = new TEntry('cidade');
        $uf = new TEntry('uf');
        $cep = new TEntry('cep');
		
		$status->addItems(['a' => 'Ativo', 
    					   'b' => 'Negativado',] );
        $logradouro->addItems([ 'a' => 'Rua', 
    						    'b' => 'Travessa',
    						    'c' => 'Praça',
    							'd' => 'Avenida',
    							'e' => 'Praça',
    							'f' => 'Estrada',
    							'g' => 'Sítio',
    							'h' => 'Fazenda',
    							'i' => 'Beco',
    							'j' => 'Acesso',
   								'k' => 'Rodovia',]);
									
        // add the fields
		$row = $this->form->addFields([ new TLabel('id') ], [ $id ],
									  [ new TLabel('Status') ], [ $status ]);
        $row->layout = ['col-sm-1 control-label', 'col-sm-3', 'col-sm-1', 'col-sm-3' ];
		
		$row = $this->form->addFields( [ new TLabel('Nome') ], [ $nome ] );
		$row->layout = ['col-sm-1 control-label', 'col-sm-11'];

		$row = $this->form->addFields( [ new TLabel('RG/IE') ], [ $rg_ie ],
									   [ new TLabel('CPF/CNPJ') ], [ $cpf_cnpj ] );
        $row->layout = ['col-sm-1 control-label', 'col-sm-3', 'col-sm-1', 'col-sm-3' ];
		
		$label1 = new TLabel('Contato', '#7D78B6', 12, 'bi');
		$label1->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$label1] );
		
		
			   $uniq = new THidden('uniq[]');
				
				$combo = new TCombo('combo[]');
				$combo->addItems(['1'=>'Telefone',
								  '2'=>'Email',
								  '3'=>'Whatsapp',
								  '4'=>'Facebook',
								  '5'=>'Site',
								  '6'=>'Twitter']);
				$text = new TEntry('text[]');
				
				$combo->setSize('100%');				
				$text->setSize('100%');
				
				$this->fieldlist = new TFieldList;
				$this->fieldlist->generateAria();
				$this->fieldlist->width = '100%';
				$this->fieldlist->name  = 'my_field_list';
				$this->fieldlist->addField( '<b>Unniq</b>',  $uniq,   ['width' => '0%', 'uniqid' => true] );
				$this->fieldlist->addField( '<b>Tipo Contato</b>',  $combo,  ['width' => '50%'] );
				$this->fieldlist->addField( '<b>Contato</b>',   $text,   ['width' => '50%'] );
				
				$this->fieldlist->enableSorting();				
				$this->form->addField($combo);
				$this->form->addField($text);
				
				//$this->fieldlist->addButtonAction(new TAction([$this, 'showRow']), 'fa:info-circle purple', 'Show text');
				//$this->fieldlist->addButtonFunction("__adianti_message('Row data', JSON.stringify(tfieldlist_get_row_data(this)))", 'fa:info-circle blue', 'Show "Text" field');
				
				$this->fieldlist->addHeader();
				
			if(isset($param['key']))
			{
			    TTransaction::open('connect'); // open a transaction

				$repository = new TRepository('Contato');
				$criteria = new TCriteria();
				$criteria->add(new TFilter('id_titular','=',$param['key']));
				$criteria->add(new TFilter('tipo_titular','=',1));
		        $contatos = $repository->load($criteria);
				//$data_contatos = new stdClass;
				
				foreach($contatos as $contato)
				{
					$i = 0;
					$obj = new stdClass; 
					$obj->combo = $contato->tipo;
					$obj->text = $contato->dado;
					
					$this->fieldlist->addDetail($obj);
					$i++;
				}
				
				 TTransaction::close(); // close the transaction
			}
			else
			{
			    TTransaction::open('connect'); // open a transaction
				$last = Customer::last();
				$id->setValue($last->id + 1);
				TTransaction::close(); // close the transaction
				$this->fieldlist->addDetail( new stdClass );
			}
		$this->fieldlist->addCloneAction();
				
		// add field list to the form
		$this->form->addContent( [$this->fieldlist] );
		
		
		$label = new TLabel('Endereço', '#7D78B6', 12, 'bi');
        $label->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$label] );
		
		$row = $this->form->addFields( [ new TLabel('Logradouro') ], [ $logradouro ],
									   [ new TLabel('Endereco') ], [ $endereco ],
									   [ new TLabel('N°') ], [ $numero ] );
        $row->layout = ['col-sm-1 control-label', 'col-sm-2', 'col-sm-0', 'col-sm-6','col-sm-0', 'col-sm-2' ];
		
		$row = $this->form->addFields( [ new TLabel('Complemen.') ], [ $complemento ],
									   [ new TLabel('Referencia') ], [ $referencia ],
									   [ new TLabel('Bairro') ], [ $bairro ]);
        $row->layout = ['col-sm-1 control-label', 'col-sm-2', 'col-sm-1', 'col-sm-3', 'col-sm-1', 'col-sm-4'  ];
		
		$row = $this->form->addFields( [ new TLabel('Cidade') ], [ $cidade ],
									   [ new TLabel('Uf') ], [ $uf ],
									   [ new TLabel('Cep') ], [ $cep ] );
									   
        $row->layout = ['col-sm-1 control-label', 'col-sm-5', 'col-sm-0', 'col-sm-1', 'col-sm-0', 'col-sm-2'];
        
        // set sizes
        $id->setEditable(false);
        $nome->setSize('100%');
        $rg_ie->setSize('100%');
        $cpf_cnpj->setSize('100%');
        $status->setSize('100%');
        // set sizes
        $logradouro->setSize('100%');
        $endereco->setSize('100%');
        $numero->setSize('100%');
        $complemento->setSize('100%');
        $referencia->setSize('100%');
        $bairro->setSize('100%');
        $cidade->setSize('100%');
        $uf->setSize('100%');
        $cep->setSize('100%');

		 //$id->addValidation('Còd', new TRequiredValidator);
        $nome->addValidation('Nome', new TRequiredValidator);
        $cpf_cnpj->addValidation('CPF/CNPJ', new TRequiredValidator);
		
		//$combo->addValidation('Tipo contato', new TRequiredValidator);
		//$text->addValidation('Contato', new TRequiredValidator);


		$endereco->addValidation('Endereco', new TRequiredValidator);
        $bairro->addValidation('Bairro', new TRequiredValidator);
        $cidade->addValidation('Cidade', new TRequiredValidator);
      
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
		
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($this->form);
        
        parent::add($container);
		
		//$this->form->appendPage('Manual form grid');

    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
        try
        {
            $this->form->validate(); // validate form data

            TTransaction::open('connect'); // open a transaction
            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/
            
            $data = $this->form->getData(); // get form data as array

			
            $cliente = new Customer;  // create an empty object
            $cliente->fromArray( (array) $data); // load the object with data
            $cliente->store(); // save the object            
            $this->form->setData($cliente); // fill form data
            

			//exclui do banco os contatos existentes
				$repository = new TRepository('Contato');
				$criteria = new TCriteria();
				$criteria->add(new TFilter('id_titular','=',$cliente->id));
				$criteria->add(new TFilter('tipo_titular','=',1));
		        $contatos = $repository->load($criteria);
				//$data_contatos = new stdClass;
				
				foreach($contatos as $contato_a_deletar)
				{
				 $contato_a_deletar->delete();
				}
			
			//percorre os contatos e grava no banco
			for ($i = 0; $i < count($data->text); $i++) {
				//echo $i;

				$contato = new Contato;
				$contato->tipo = $data->combo[$i];
				$contato->dado = $data->text[$i];
				$contato->tipo_titular = 1;
				$contato->id_titular = $cliente->id;
				$contato->store();

			}			
            
            $endereco = new Endereco;  // create an empty object
            $endereco->fromArray( (array) $data); // load the object with data
			
			$endereco->id_titular = $cliente->id;;
			$endereco->tipo_titular = 1;
            $endereco->store(); // save the object
            $this->form->setData($endereco); // fill form data           

            
                        
            TTransaction::close(); // close the transaction
            
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Clear form data
     * @param $param Request
     */
     public static function showRow($param)
    {
        new TMessage('info', str_replace(',', '<br>', json_encode($param)));
    }
    
    /**
     * Clear form
     */
    public static function onClear($param)
    {
        TFieldList::clear('my_field_list');
        TFieldList::addRows('my_field_list', 4);
    }
    
    /**
     * Fill data
     */
    public static function onFill($param)
    {
		

    }
    
    /**
     * Fill data
     */
    public static function onClearFill($param)
    {
    
        TFieldList::clear('my_field_list');
        TFieldList::addRows('my_field_list', 4);
        
        $data = new stdClass;
        $data->combo  = [ 1,2,3,4,5 ];
        $data->text   = [ 'Part. One', 'Part. Two', 'Part. Three', 'Part. Four', 'Part. Five' ];
        
        TForm::sendData('form_Customer', $data, false, true, 200); // 200 ms of timeout after recreate rows!
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('connect'); // open a transaction
                $customer = new Customer($key); // instantiates the Active Record
                $this->form->setData($customer); // fill the form				
				
				$obj_endereco = Endereco::find($key)->hasMany('Endereco','id_titular','id','id'); // instantiates the Active Record
   			    $this->form->setData($obj_endereco[0]); // fill the form				

                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}
