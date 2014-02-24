<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	protected function redirigir($titulo, $mensaje, $tipo, $url, $layout, $icono = 'fa-exclamation-triangle')
	{
		Yii::app()->user->setState('titulo', $titulo);
		Yii::app()->user->setState('mensaje', $mensaje);
		Yii::app()->user->setState('tipo', $tipo);
		Yii::app()->user->setState('url', $url);
		Yii::app()->user->setState('layout', $layout);
		
		
		//Yii::app()->user->setState('redireccion', $redireccion);
		Yii::app()->user->setState('icono', $icono);
		$this->redirect(array('site/mensaje'));
	}
}