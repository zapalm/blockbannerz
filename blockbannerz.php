<?php
/**
 * Block Banners: module for PrestaShop 1.5-1.6
 *
 * @author zapalm <zapalm@ya.ru>
 * @copyright (c) 2013-2015, zapalm
 * @link http://prestashop.modulez.ru/en/ Homepage
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_'))
	exit;

class BlockBannerz extends Module
{
	public function __construct()
	{
		$this->name = 'blockbannerz';
		$this->tab = 'advertising_marketing';
		$this->version = '0.1.1';
		$this->author = 'zapalm';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.5.0.0', 'max' => '1.6.1.0');
		$this->bootstrap = false;

		parent::__construct();

		$this->displayName = $this->l('Block advertisement banners');
		$this->description = $this->l('Adds an advertisement block to selected sections of your e-commerce webiste.');
	}

	public function install()
	{
		return parent::install()
			&& $this->registerHook('displayHeader')
			&& $this->registerHook('displayTop')
			&& $this->registerHook('displayHome')
		;
	}

	public function uninstall()
	{
		return parent::uninstall();
	}

	private function _hookCommon()
	{
		if (!$this->isCached('blockbannerz.tpl', $this->getCacheId()))
		{
			$this->smarty->assign(array(
				'top' => false,
				'home' => false,
			));
		}
	}

	public function hookDisplayTop($params)
	{
		$this->_hookCommon();

		$this->smarty->assign(array(
			'top' => true,
			'image_top' => $this->_path.'img/top.jpg',
		));

		return $this->display(__FILE__, 'blockbannerz.tpl', $this->getCacheId());
	}

	public function hookDisplayHome($params)
	{
		$this->_hookCommon();

		$this->smarty->assign(array(
			'home' => true,
			'image_home1' => $this->_path.'img/home1.jpg',
			'image_home2' => $this->_path.'img/home2.jpg',
		));

		return $this->display(__FILE__, 'blockbannerz.tpl', $this->getCacheId());
	}

	public function hookDisplayHeader($params)
	{
		$this->context->controller->addCSS($this->_path.'blockbannerz.css', 'all');
	}
}