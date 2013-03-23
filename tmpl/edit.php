<?php
/**
* @version 			Seblod 2.0 More $Revision: 12 $
* @package			Seblod (CCK for Joomla)
* @author       	http://www.seblod.com
* @copyright		Copyright (C) 2011 Seblod. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

// No Direct Access
defined( '_JEXEC' ) or die;
?>

<?php
$options2	=	CCK_Dev::fromJSON( $this->item->options2 );
//$config['doTranslation'] = 0;
?>

<div class="seblod">	
	<?php echo CCK_Dev::renderLegend( JText::_( 'COM_CCK_CONSTRUCTION' ), JText::_( 'PLG_CCK_FIELD_'.$this->item->type.'_DESC' ) ); ?>
	<ul class="adminformlist adminformlist-2cols">
		<?php
		echo CCK_Dev::renderForm('wm_core_field_mijoshop_address_company', @$options2['company'], $config);
		echo CCK_Dev::renderForm('wm_core_field_mijoshop_address_address_1', @$options2['address_1'], $config);
		echo CCK_Dev::renderForm('wm_core_field_mijoshop_address_address_2', @$options2['address_2'], $config);
		echo CCK_Dev::renderForm('wm_core_field_mijoshop_address_country_id', @$options2['country_id'], $config);
		echo CCK_Dev::renderForm('wm_core_field_mijoshop_address_zone_id', @$options2['zone_id'], $config);
		echo CCK_Dev::renderForm('wm_core_field_mijoshop_address_postcode', @$options2['postcode'], $config);
		echo CCK_Dev::renderForm('wm_core_field_mijoshop_address_city', @$options2['city'], $config);
		

		//echo CCK_Dev::renderSpacer( JText::_( 'COM_CCK_STORAGE' ), JText::_( 'COM_CCK_STORAGE_DESC' ) );
		//echo CCK_Dev::getForm( 'core_storage', $this->item->storage, $config );
        ?>
    </ul>
</div>
