<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Field
 */
final class NF_Database_Models_Field extends NF_Abstracts_Model
{
    private $form_id = '';

    protected $_type = 'field';

    protected $_table_name = 'nf3_fields';

    protected $_meta_table_name = 'nf3_field_meta';

    protected $_columns = array(
        'label',
        'key',
        'parent_id',
        'type',
        'created_at'
    );
    public function __construct( $db, $id, $parent_id = '' )
    {
        parent::__construct( $db, $id, $parent_id );
    }

    public function delete() {
    	parent::delete();

    	// delete data for field if it exists
    	$this->deleteData();
    }

    private function deleteData() {

    	// check for numeric ids only
    	if( is_numeric( $this->_id ) ) {
    		// delete submitted values for deleted field
		    $this->_db->delete(
			    $this->_db->prefix . 'postmeta',
			    array(
				    'meta_key' => '_field_' . $this->_id
			    )
		    );
	    }
    }

    public static function import( array $settings, $field_id = '', $is_conversion = FALSE )
    {
        $settings = apply_filters( 'ninja_forms_before_import_fields', $settings );
        $settings[ 'saved' ] = 1;

        if( $field_id && $is_conversion ) {
            $field = Ninja_Forms()->form()->field( $field_id )->get();
        } else {
            $field = Ninja_Forms()->form()->field()->get();
        }
        $field->update_settings( $settings );
        $field->save();
    }

} // End NF_Database_Models_Field
