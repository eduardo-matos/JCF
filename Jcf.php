<?php

class Cf_Controller_Action_Helper_Jcf extends Zend_Controller_Action_Helper_Abstract
{

	/**
	 * @var bool Defines if it's  allowed to overwrite some variable.
	 */
	protected $_overwrite = true;
	
	/**
	 * @var array Variables that will be in javscript are contained here.
	 */
	protected $_vars = array();
	
	/**
	 * Creates a new variable in javscript.
	 * If the variable already exists and $_overwrite property 
	 * is set to true, then it's overwriten.
	 *
	 * @param string $key
	 * @param mix $value
	 * @param bool $value
	 */
	public function direct($key, $value)
	{
		$this->__set($key, $value);
	}
	
	/**
	 * Defines if it's allowed to overwrite variables.
	 *
	 * @param bool $overwrite
	 */
	public function setAllowOverwrite($overwrite = true)
	{
		$this->_overwrite = (bool)$overwrite;
	}
	
	/**
	 * @return array
	 */
	public function getVars()
	{
		return $this->_vars;
	}
	
	/**
	 * @param string $key
	 * @param mix $value
	 * @param bool $value
	 */
	public function __set($key, $value)
	{
		if(!is_string($key) || preg_match('/[^a-zA-Z]/', $key)) {
			throw new Exception('Key must be integer or string and contain only letters (no accents)!');
		}
		
		if(true === $this->_overwrite) {
			$this->_vars[$key] = $value;
		} elseif(!$this->__isset($key)) {
			$this->_vars[$key] = $value;
		}

	}
	
	/**
	 * @param string $key
	 */
	public function __unset($key)
	{
		if($this->__isset($key)) {
			unset($this->_vars[$key]);
		}
	}
	
	/**
	 * @param string $key
	 * @return bool
	 */
	public function __isset($key)
	{
		return array_key_exists($key, $this->_vars);
	}

	/**
	 * @return Cf_Controller_Action_Helper_Jcf
	 */
	public function clear()
	{
		$this->_vars = array();
		return $this;
	}

	/**
	 * Convert variables to JSON, and inject them in view scripts.
	 * It's cricial to include headScript view helper in the view/layout
	 */
	public function postDispatch()
	{
		$vars = ($this->_vars);
		if(!empty($vars)) {			
			$json = Zend_Json::encode($vars);			
			$this->getActionController()->view->headScript()->offsetSetScript(-10000, 'var jcf = ' . $json . ';');
		}

	}
	
	
}