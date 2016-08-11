{**
 * Block Banners: module for PrestaShop 1.5-1.6
 *
 * @author    zapalm <zapalm@ya.ru>
 * @copyright (c) 2013-2015, zapalm
 * @link      http://prestashop.modulez.ru/en/ Homepage
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

<!-- MODULE blockbannerz -->
{if $top}
	<div class="blockbannerz_top">
		<img src="{$image_top}" alt="" title="" />
	</div>
{elseif $home}
	<div class="blockbannerz_home">
		<img src="{$image_home1}" alt="" title="" />
		<img src="{$image_home2}" alt="" title="" />
	</div>
{/if}
<!-- /MODULE blockbannerz -->
