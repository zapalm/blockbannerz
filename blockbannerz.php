<?php
/**
 * Block Banners: module for PrestaShop 1.6
 *
 * @author    zapalm <zapalm@ya.ru>
 * @copyright (c) 2013-2016, zapalm
 * @link      http://prestashop.modulez.ru/en/free-products/41-simple-block-of-banners.html The module's homepage
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_'))
	exit;

class BlockBannerz extends Module
{
	public function __construct()
	{
		$this->name = 'blockbannerz';
		$this->tab = 'advertising_marketing';
		$this->version = '0.4.0';
		$this->author = 'zapalm';
		$this->need_instance = 0;
		$this->bootstrap = false;

		parent::__construct();

		$this->displayName = $this->l('Block advertisement banners');
		$this->description = $this->l('Adds an advertisement images to a different sections of your e-commerce website.');
	}

	public function install()
	{
		return parent::install()
			&& $this->registerHook('header')
			&& $this->registerHook('top')
			&& $this->registerHook('home')
		;
	}

	public function uninstall()
	{
		return parent::uninstall();
	}

	public function getContent()
	{
		$output = '';
		$errors = array();
		$banners = array('top', 'home1', 'home2');
		$upload_dir = _PS_MODULE_DIR_.$this->name.'/img/';

		if (Tools::isSubmit('submit_save'))
		{
			foreach ($banners as $banner)
			{
				if (isset($_FILES[$banner]) && !empty($_FILES[$banner]['tmp_name']))
				{
					if ($msg = ImageManager::validateUpload($_FILES[$banner], Tools::convertBytes(ini_get('upload_max_filesize'))))
						$errors[] = $msg;
					else
					{
						// copy the image to the module directory with its new name
						// todo: it saves file always with jpg extension
						if (!move_uploaded_file($_FILES[$banner]['tmp_name'], $upload_dir.$banner.'.jpg'))
							$errors[] = $this->l('Error while moving uploaded file').': '.$banner;
					}
				}
			}

			$output .= $errors ? $this->displayError(implode('<br/>', $errors)) : $this->displayConfirmation($this->l('Settings updated'));
		}

		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		return '
			<form action="'.$_SERVER['REQUEST_URI'].'" method="post"  enctype="multipart/form-data">
				<fieldset>
					<legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
					<label>'.$this->l('Change top banner').'</label>
					<div class="margin-form">
						<input type="file" name="top" />
					</div>
					<label>'.$this->l('Change home left banner').'</label>
					<div class="margin-form">
						<input type="file" name="home1" />
					</div>
					<label>'.$this->l('Change home right banner').'</label>
					<div class="margin-form">
						<input type="file" name="home2" />
					</div>
					<div class="margin-form">
						<input type="submit" name="submit_save" value="'.$this->l('Save').'" class="button" />
					</div>
					<p>'.
						$this->l('Maximum allowed size for uploaded files:').' '.ini_get('upload_max_filesize').'<br/>'.
						$this->l('Maximum number of files that can be uploaded at the same time:').' '.ini_get('max_file_uploads').'
					</p>
				</fieldset>
			</form>
		';
	}

	public function hookTop($params)
	{
		$this->smarty->assign(array(
			'image_top' => $this->_path.'img/top.jpg',
		));

		return $this->display(__FILE__, 'views/hook/top.tpl');
	}

	public function hookHome($params)
	{
		$this->smarty->assign(array(
			'image_home1' => $this->_path.'img/home1.jpg',
			'image_home2' => $this->_path.'img/home2.jpg',
		));

		return $this->display(__FILE__, 'views/hook/home.tpl');
	}

	public function hookHeader($params)
	{
		$this->context->controller->addCSS($this->_path . 'views/css/blockbannerz.css', 'all');
	}
}