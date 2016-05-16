<?php
/**
 * Clase base para los controladores
 */

/**
 * Clase base para los controladores
 */
class Controller extends Application {
	
    protected $controller;
   	protected $action;
	protected $view;
	protected $template;
	/**
	 * constructor, carga los helper en automatico
	 * @param string $controller nombre del controlador
	 * @param string $action accion de del controlador
	 */
	public function __construct($controller, $action) {
		parent::__construct();
		$this->controller = $controller;
		$this->action = $action;
		$this->view = new View();
		$this->template = DEFAULT_TEMPLATE;
	}

	public function getModel(){
        if (property_exists($this->controller, '_model')) {
			$properties = get_class_vars($this->controller);
			return $properties['model'];
        }else{
        		return $this->controller.'Model';
        }
	}

	protected function getView() {
		return $this->view;
	}

	protected function checkToken($Token,$formName,$f){
		if( $Token === $this->generateToken( $formName ) ){
			return true;
		}else{
			$f();
			return false;
		}
	}

	protected function setTemplate($template) {
		$this->template=$template;
	}

	protected function addHelper($helper) {
		if (file_exists(ROOT.DS.'application'.DS.'controllers'.DS.'helpers'.DS.strtolower($helper).'.php')){
        	require_once(ROOT.DS.'application'.DS.'controllers'.DS.'helpers'.DS.strtolower($helper).'.php');
    	}
	}

	/**
	 * Wrapper para render, renderiza una vista todo en uno 
	 * @param  string $view_name nombre de la vista, la vista tiene que estar en view en general se organiza en carpetas
	 * @param  string $mesaje    mensaje a mostrar
	 * @param  string $type      tipo de mensaje
	 * @param  array  $vars      Array que contenga las variables de la vita 
	 * @param  string $template  Template 
	 */
	protected function renderView($view_name=null){
		if (!isset($view_name)) {
			$view_name = strtolower($this->controller).'/'.$this->action;
		}
		$this->view->render($view_name,$this->template);
	}

	protected function setVars($vars){
		foreach($vars as $var => $value) {
			$this->view->set($var,$value);
		}
	}

	/**
	 * Wrapper para poner variables en la vista
	 * @param string $var   nombre de la variable
	 * @param object $value valor
	 */
	protected function setVar($var,$value){
		$this->view->set($var,$value);
	}

	protected function addCss($csss){
		$this->view->addCss($csss);
	}
	protected function addJs($jss){
		$this->view->addJs($jss);
	}

}