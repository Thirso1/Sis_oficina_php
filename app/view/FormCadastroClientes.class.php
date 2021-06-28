<?php
/**
 * FormCadastroClientes
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FormCadastroClientes extends TPage
{
    private $form;
    
    /**
     * Class constructor
     */
    function __construct()
    {
        parent::__construct();
        
        // create the form
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle(_t('Cadastro de Clientes'));
		//$this->form->setFieldSizes('100%');
        $this->form->generateAria(); // automatic aria-label
		$this->form->setClientValidation(true);
        
		TTransaction::open('connect'); // open transaction 
		try
		{
			$last = Customer::last();
			TTransaction::close(); // Closes the transaction 			
        } 
        catch (Exception $e) 
        { 
            new TMessage('error', $e->getMessage()); 
        } 
        // create the form fields
        $id         	 = new TEntry('id');
		$nome       	 = new TEntry('nome');
		$rg_ie      	 = new TEntry('rg_ie');
		$cpf_cnpj   	 = new TEntry('cpf_cnpj');
		$telefone_1 	 = new TEntry('telefone_1');
		$telefone_2 	 = new TEntry('telefone_2');
        $email      	 = new TEntry('email');
        $tipo_logradouro = new TCombo('tipo_logradouro');
        $logradouro      = new TEntry('logradouro');
        $numero          = new TEntry('numero');
        $complemento     = new TEntry('complemento');
        $referencia      = new TEntry('referencia');
		$bairro          = new TEntry('bairro');
        $cidade          = new TEntry('cidade');
        $uf              = new TEntry('uf');
        $cep             = new TEntry('cep');
        //$id->setEditable(FALSE);
      		

        $tipo_logradouro->setSize('30%');
        $tipo_logradouro->addItems(['a' => 'Rua', 
									'b' => 'Travessa',
									'c' => 'Praça',
									'd' => 'Avenida',
									'e' => 'Praça',
									'f' => 'Estrada',
									'g' => 'Sítio',
									'h' => 'Fazenda',
									'i' => 'Beco',
									'j' => 'Acesso',
									'k' => 'Rodovia',] );
        $logradouro->setSize('100%');
        $numero->setSize('20%');

        // disable dates (bootstrap date picker)        
        // $weight->setValue(30);
        //$type->setValue('a');
		
        $id->setValue($last->id + 1);//incrementa o id do ultimo cliente cadastrado

        // add the fields inside the form
        $this->form->addFields( [new TLabel('Id')],          [$id]);
        $this->form->addFields( [new TLabel('Nome')],        [$nome] );
		$this->form->addFields( [new TLabel('RG/IE')],       [$rg_ie] ,
								[new TLabel('CPF/CNPJ')],    [$cpf_cnpj]);
								
		$label1 = new TLabel('Contato', '#7D78B6', 12, 'bi');
		$label1->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$label1] );	
		
		$this->form->addFields( [new TLabel('Telefone 1')],     [$telefone_1] ,
								[new TLabel('Telefone 2')],     [$telefone_2]);
		$this->form->addFields( [new TLabel('E-mail')],         [$email] );

		$label = new TLabel('Endereço', '#7D78B6', 12, 'bi');
        $label->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$label] ); 
		
        $this->form->addFields( [new TLabel('Tipo Logradouro')],[$tipo_logradouro] );
		$this->form->addFields(	[new TLabel('Logradouro')],     [$logradouro],
								[new TLabel('N°')],             [$numero]);
		$this->form->addFields( [new TLabel('Complemento')],    [$complemento] ,
								[new TLabel('Referencia')],     [$referencia]);
		$this->form->addFields( [new TLabel('Bairro')],         [$bairro] ,
								[new TLabel('Cidade')],         [$cidade]);
		$this->form->addFields( [new TLabel('Uf')],             [$uf] ,
								[new TLabel('Cep')],            [$cep]);
								
        $nome->placeholder = 'Nome do cliente';
        //$nome->setTip('Tip for description');               
        //validacoes
		$email->addValidation('email', new TEmailValidator); // email field
        $email->addValidation('email', new TRequiredValidator); // email field

        // define the form action 
        $this->form->addAction('Send', new TAction(array($this, 'onSend')), 'far:check-circle green');
        $this->form->addHeaderAction('Send', new TAction(array($this, 'onSend')), 'fa:rocket orange');
        
       
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        // $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        parent::add($vbox);
    }
    
    /**
     * Simulates an save button
     * Show the form content
     */
    public function onSend($param)
    {
		try{
			
        $data = $this->form->getData();
        
        // put the data back to the form
        $this->form->setData($data);
        
		// run form validation
        $this->form->validate();
        // creates a string with the form element's values
        $message = 'Id: '           . $data->id . '<br>';
        $message.= 'Nome : '        . $data->nome . '<br>';
        $message.= 'RG/IE : '       . $data->rg_ie . '<br>';
		$message.= 'CPF/CNPJ : '    . $data->cpf_cnpj . '<br>';
        $message.= 'E-mail : '      . $data->email . '<br>';
        
		
        // show the message
        new TMessage('info', $message);
		}
		catch (Exception $e) 
		{
			new TMessage('error', $e->getMessage());
		}
		
		try 
        { 
            TTransaction::open('connect'); // open transaction 
            
            // create a new object
            $customer = new Customer;
            $customer->id        = $data->id; 			
            $customer->nome      = $data->nome; 
            $customer->rg_ie     = $data->rg_ie; 
            $customer->cpf_cnpj  = $data->cpf_cnpj; 
            $customer->status    = 'ativo'; 
        
            $customer->store(); // store the object 
            
			$endereco = new Endereco;
            $endereco->id           = '180'; 			
            $endereco->logradouro   = $data->tipo_logradouro; 
            $endereco->endereco     = $data->logradouro; 
            $endereco->numero       = $data->numero; 
            $endereco->complemento  = $data->complemento; 
            $endereco->referencia   = $data->referencia; 			
            $endereco->bairro       = $data->bairro; 
            $endereco->cidade       = $data->cidade; 
            $endereco->uf           = $data->uf; 
            $endereco->cep          = $data->cep; 
			$endereco->tipo_titular = 1; 
            $endereco->id_titular   = $data->id; 

            $endereco->store(); // store the object 
			
            new TMessage('info', 'Cliente cadastrado com sucesso!'); 
            TTransaction::close(); // Closes the transaction 
        } 
        catch (Exception $e) 
        { 
            new TMessage('error', $e->getMessage()); 
        } 
    }
}
?>