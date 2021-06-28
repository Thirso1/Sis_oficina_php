<?php
/**
 * CustomerForm Form
 * @author  <your name here>
 */
class FormCadastroFornecedor extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Fornecedor');
        $this->form->setFormTitle('Fornecedor');
		
        // create the form fields
        $id          = new TEntry('id');
        $nome        = new TEntry('nome_fantasia');
        $razao_social= new TEntry('razao_social');
        $cnpj        = new TEntry('cnpj');
        $status      = new TCombo('status');
        $logradouro  = new TCombo('logradouro');
        $endereco    = new TEntry('endereco');
        $numero 	 = new TEntry('numero');
        $complemento = new TEntry('complemento');
        $referencia  = new TEntry('referencia');
        $bairro      = new TEntry('bairro');
        $cidade      = new TEntry('cidade');
        $uf          = new TEntry('uf');
        $cep         = new TEntry('cep');
		
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

		$row = $this->form->addFields( [ new TLabel('Razao Social') ], [ $razao_social ],
									   [ new TLabel('CNPJ') ], [ $cnpj ] );
        $row->layout = ['col-sm-1 control-label', 'col-sm-3', 'col-sm-1', 'col-sm-3' ];
		
		$divisoria_contato = new TLabel('Contato', '#7D78B6', 12, 'bi');
		$divisoria_contato->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$divisoria_contato] );
		
		
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
				$this->form->addField($uniq);				
				$this->form->addField($combo);
				$this->form->addField($text);

				$this->fieldlist->addHeader();
				
			if(isset($param['key'])) 											//se foi passado algum id de parametro
			{
			    TTransaction::open('connect'); 									// open a transaction

				$repository = new TRepository('Contato');						//traz uma coleção com todos os contatos
				$criteria = new TCriteria();									
				$criteria->add(new TFilter('id_titular','=',$param['key']));	//cria filtro por id
				$criteria->add(new TFilter('tipo_titular','=',2));				//cria filtro por tipo de pessoa
				//var_dump($criteria->dump());
		        $contatos = $repository->load($criteria);						//aplica o filtro a coleção
				//$data_contatos = new stdClass;
				
				
				foreach($contatos as $contato)									//para cada contato adiciona um fieldlist
				{
					$i = 0;
					$obj = new stdClass; 
					$obj->uniq = $contato->id;
					$obj->combo = $contato->tipo;
					$obj->text = $contato->dado;
					
					$this->fieldlist->addDetail($obj);
					$i++;
				}
				
				 TTransaction::close(); // close the transaction
			}
			else																//senao recebeu id como parametro
			{
			    TTransaction::open('connect'); // open a transaction
				$last = Fornecedor::last();   //busca o ultimo id de fornecedores
				$id->setValue($last->id + 1); //incrementa um
				TTransaction::close(); // close the transaction
				$this->fieldlist->addDetail( new stdClass ); ////cria um field list vazio
			}
		$this->fieldlist->addCloneAction();  //adiciona o botao de clone
				
		// add field list to the form
		$this->form->addContent( [$this->fieldlist] ); //adiciona um field list vazio
		
		$divisoria_endereco = new TLabel('Endereço', '#7D78B6', 12, 'bi');
        $divisoria_endereco->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$divisoria_endereco] );
		
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
        
				
		$divisoria_vendedor = new TLabel('Representante', '#7D78B6', 12, 'bi');
		$divisoria_vendedor->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$divisoria_vendedor] );
		
				$uniq_vendedor = new THidden('uniq_vendedor[]');
				$nome_vendedor = new TEntry('nome_vendedor[]');				
				$combo_vendedor = new TCombo('combo_vendedor[]');
				$combo_vendedor->addItems(['1'=>'Telefone',
								  '2'=>'Email',
								  '3'=>'Whatsapp',
								  '4'=>'Facebook',
								  '5'=>'Site',
								  '6'=>'Twitter']);
				$contato_vendedor = new TEntry('text[]');
								
				$nome_vendedor->setSize('100%');
				$combo_vendedor->setSize('100%');				
				$contato_vendedor->setSize('100%');
				
				$this->fl_vendedor = new TFieldList;
				$this->fl_vendedor->generateAria();
				$this->fl_vendedor->width = '100%';
				$this->fl_vendedor->name  = 'field_listfl_vendedor';
				$this->fl_vendedor->addField( '<b>Unniq</b>',  $uniq_vendedor,   ['width' => '0%', 'uniqid' => true] );
				$this->fl_vendedor->addField( '<b>Nome</b>',   $nome_vendedor,   ['width' => '33%'] );
				$this->fl_vendedor->addField( '<b>Tipo Contato</b>',  $combo_vendedor,  ['width' => '33%'] );
				$this->fl_vendedor->addField( '<b>Contato</b>',   $contato_vendedor,   ['width' => '33%'] );
				
				$this->fl_vendedor->enableSorting();
				$this->form->addField($uniq_vendedor);				
				$this->form->addField($nome_vendedor);				
				$this->form->addField($combo_vendedor);
				$this->form->addField($contato_vendedor);

				$this->fl_vendedor->addHeader();
				
			if(isset($param['key'])) 												//se foi passado algum id de parametro
			{
			    TTransaction::open('connect'); 										// open a transaction

				$repository_2 = new TRepository('Vendedor');						//traz uma coleção com todos os contatos
				$criteria_2 = new TCriteria();									
				$criteria_2->add(new TFilter('id_fornecedor','=',$param['key']));	//cria filtro por id
		        $vendedores = $repository_2->load($criteria_2);						//aplica o filtro a coleção
				//$data_contatos = new stdClass;
				
				foreach($vendedores as $vendedor)									//para cada contato adiciona um fieldlist
				{
					$i = 0;
					$obj = new stdClass; 
					$obj->uniq_vendedor = $vendedor->id;
					$obj->nome_vendedor = $vendedor->nome;
					$obj->combo_vendedor = $vendedor->tipo_contato;
					echo $vendedor->contato;
					$obj->contato_vendedor = 'teste';
					
					$this->fl_vendedor->addDetail($obj);
					$i++;
				}
				
				 TTransaction::close(); // close the transaction
			}
			else	//senao recebeu id como parametro
			{
			    TTransaction::open('connect'); // open a transaction
				$last = Fornecedor::last();   //busca o ultimo id de fornecedores
				$id->setValue($last->id + 1); //incrementa um
				TTransaction::close(); // close the transaction
				$this->fl_vendedor->addDetail( new stdClass ); ////cria um field list vazio
			}
		$this->fl_vendedor->addCloneAction();  //adiciona o botao de clone
				
		// add field list to the form
		$this->form->addContent( [$this->fl_vendedor] ); //adiciona um field list vazio		
		
		
        // set sizes
        $id->setEditable(false);
        $nome->setSize('100%');
        $razao_social->setSize('100%');
        $cnpj->setSize('100%');
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
        $cnpj->addValidation('CNPJ', new TRequiredValidator);
		
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

			
            $fornecedor = new Fornecedor;  // create an empty object
            $fornecedor->fromArray( (array) $data); // load the object with data
            $fornecedor->store(); // save the object            
            $this->form->setData($fornecedor); // fill form data
            
			//percorre os contatos e grava no banco
			for ($i = 0; $i < count($data->combo); $i++) {
				$contato = new Contato;
				$contato->id   = $data->uniq[$i];;
				$contato->tipo = $data->combo[$i];
				$contato->dado = $data->text[$i];
				$contato->tipo_titular = 2;
				$contato->id_titular = $fornecedor->id;
				$contato->store();
				//new TMessage('info', json_encode($contato));
			}			
            
            $endereco = new Endereco;  // create an empty object
            $endereco->fromArray( (array) $data); // load the object with data
			var_dump($endereco);
			$endereco->id_titular = $fornecedor->id;
			$endereco->tipo_titular = 2;
            $endereco->store(); // save the object
            $this->form->setData($endereco); // fill form data           

			for ($i = 0; $i < count($data->combo); $i++) {
				$vendedor = new Vendedor;
				$vendedor->id  			 = $data->uniq_vendedor[$i];;
				$vendedor->nome 		 = $data->nome_vendedor[$i];
				$vendedor->tipo_contato  = $data->combo_vendedor[$i];
				$vendedor->contato 		 = $data->contato_vendedor[$i];
				$vendedor->id_fornecedor =  $fornecedor->id;
				var_dump($vendedor);
				$vendedor->store();
				//new TMessage('info', json_encode($contato));
			}	
            
                        
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
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  										  // get the parameter $key
                TTransaction::open('connect'); 								  // open a transaction
                $fornecedor = new Fornecedor($key); 						  // instantiates the Active Record
                $this->form->setData($fornecedor); 							  // fill the form				
																				
				$repository = new TRepository('Endereco');					  //cria uma coleção com todos os fornecedores
				$criteria = new TCriteria();
				$criteria->add(new TFilter('id_titular','=',$fornecedor->id));//adiciona o filtro id ao criterio
				$criteria->add(new TFilter('tipo_titular','=',2));			  //adiciona o filtro tipo_titular ao criterio
				$obj_endereco = $repository->load($criteria); 				  // instantiates the Active Record
   			    $this->form->setData($obj_endereco[0]); 					  // fill the form				

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
