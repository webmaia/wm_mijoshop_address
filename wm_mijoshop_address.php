<?php
/**
* @version          SEBLOD 2.x Core
* @package          SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url              http://www.seblod.com
* @editor           Octopoos - www.octopoos.com
* @copyright        Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license          GNU General Public License version 2 or later; see _LICENSE.php
**/

// No Direct Access
defined( '_JEXEC' ) or die;

// Plugin
class plgCCK_FieldWm_Mijoshop_Address extends JCckPluginField
{
    protected static $type      =   'wm_mijoshop_address';
    protected static $path;
    
    // -------- -------- -------- -------- -------- -------- -------- -------- // Construct
    
    // onCCK_FieldConstruct
    public function onCCK_FieldConstruct( $type, &$data = array() )
    {
        if ( self::$type != $type ) {
            return;
        }
        parent::g_onCCK_FieldConstruct( $data );
    }
    
    // -------- -------- -------- -------- -------- -------- -------- -------- // Prepare
    
    // onCCK_FieldPrepareContent
    public function onCCK_FieldPrepareContent( &$field, $value = '', &$config = array() )
    {
        if ( self::$type != $field->type ) {
            return;
        }
        parent::g_onCCK_FieldPrepareContent( $field, $config );
        
        // Set
        $field->value   =   $value;
    }
    
    // onCCK_FieldPrepareForm
    public function onCCK_FieldPrepareForm( &$field, $value = '', &$config = array(), $inherit = array(), $return = false )
    {   

        if(self::$type != $field->type){
            return;
        }

        self::$path =   parent::g_getPath( self::$type.'/' );
        parent::g_onCCK_FieldPrepareForm( $field, $config );
        
        // Init
        if ( count( $inherit ) ) {
            $id     =   ( @$inherit['id'] != '' ) ? $inherit['id'] : $field->name;
            $name   =   ( @$inherit['name'] != '' ) ? $inherit['name'] : $field->name;
        } else {
            $id     =   $field->name;
            $name   =   $field->name;
        }
        $value      =   ( $value != '' ) ? $value : $field->defaultvalue;
        $value      =   ( $value != ' ' ) ? $value : '';
        $value      =   htmlspecialchars( $value, ENT_QUOTES );
        
        // Validate
        $validate   =   '';
        if ( $config['doValidation'] > 1 ) {
            plgCCK_Field_ValidationRequired::onCCK_Field_ValidationPrepareForm( $field, $id, $config );
            parent::g_onCCK_FieldPrepareForm_Validation( $field, $id, $config );
            if ( $field->minlength > 0 ) {
                $field->validate[]  =   'minSize['.$field->minlength.']';
            }
            $validate   =   ( count( $field->validate ) ) ? ' validate['.implode( ',', $field->validate ).']' : '';
        }
        
        // Prepare
        //$class    =   'inputbox text'.$validate.' '.$field->css;
        //$maxlen   =   ( $field->maxlength > 0 ) ? 'maxlength="'.$field->maxlength.'" ' : '';
        //$size =   'size="'.$field->size.'" ';
        //$style    =   ( @$field->style ) ? 'style="'.$field->style.'" ' : '';
        
        //$attr =   'class="'.$class.'" '.$maxlen.$size.$style.$field->attributes;
        //$form =   '<input type="text" id="'.$id.'" name="'.$name.'" value="'.$value.'" '.$attr.' />';
        
        // Set
        if ( ! $field->variation ) {
            $field->form    =   $form;
            if ( $field->script ) {
                parent::g_addScriptDeclaration( $field->script );
            }
        } else {
            parent::g_getDisplayVariation( $field, $field->variation, $value, $value, $form, $id, $name, '<input' );
        }
        $field->value   =   $value;
        
        // Return
        if ( $return === true ) {
            return $field;
        }

        
    }
    
    // onCCK_FieldPrepareSearch
    public function onCCK_FieldPrepareSearch( &$field, $value = '', &$config = array(), $inherit = array(), $return = false )
    {
        if ( self::$type != $field->type ) {
            return;
        }
        
        // Prepare
        self::onCCK_FieldPrepareForm( $field, $value, $config, $inherit, $return );
        
        // Return
        if ( $return === true ) {
            return $field;
        }
    }
    
    // onCCK_FieldPrepareStore
    public function onCCK_FieldPrepareStore( &$field, $value = '', &$config = array(), $inherit = array(), $return = false )
    {
        
        
        
        if ( self::$type != $field->type ) {
            return;
        }
        


        // Init
        if ( count( $inherit ) ) {
            $name   =   ( @$inherit['name'] != '' ) ? $inherit['name'] : $field->name;
        } else {
            $name   =   $field->name;
        }
        
        // Validate
        parent::g_onCCK_FieldPrepareStore_Validation( $field, $name, $value, $config );
        
        // Set or Return
        if ( $return === true ) {
            return $value;
        }
        $field->value   =   $value;

        //parent::g_onCCK_FieldPrepareStore( $field, $name, $value, $config );

        $user = JFactory::getUser();
        
        $db = & JFactory::getDBO() ;
        
        $sql =  " SELECT *"
        . " FROM #__mijoshop_customer AS c "
        . " LEFT JOIN #__mijoshop_address AS a ON a.customer_id = c.customer_id"
        . " WHERE c.email = '$user->email'"
        . " LIMIT 1";
        
        $db->setQuery($sql) ;
        
        $customer = $db->loadObject();

        $mfs = JCckDev::fromJSON($field->options2);

        /* recebe dados options2 em um array, verifica se a tabela foi atribuida e então através do value
        pega em post['config'] o valor do post */

        $listFields = array();
        foreach ($mfs as $mfKey => $mfValue) {
            if($mfValue){
                $listFields[$mfKey] = $config['post'][$mfValue];
            }else{
                $listFields[$mfKey] ='';
            }

        }


        foreach ($listFields as $mField => $mValue) {
            if($customer){    
                $db = & JFactory::getDBO() ;            
                 $query = "UPDATE #__mijoshop_address
                 SET $mField  ='$mValue'
                 WHERE customer_id =".$customer->customer_id;
                 $db->setQuery($query);
                 $db->query();
                 
                 if ($db->getErrorNum())
                 {
                    JError::raiseWarning(500, $db->getErrorMsg());
                    return null;
                 };
                 
             }else{
                return NULL;
             }
            }

        }
        
    // -------- -------- -------- -------- -------- -------- -------- -------- // Render
        
    // onCCK_FieldRenderContent
        public static function onCCK_FieldRenderContent( $field, &$config = array() )
        {
            return parent::g_onCCK_FieldRenderContent( $field );
        }
        
    // onCCK_FieldRenderForm
        public static function onCCK_FieldRenderForm( $field, &$config = array() )
        {
            return parent::g_onCCK_FieldRenderForm( $field );
        }
    }
    ?>