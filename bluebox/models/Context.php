<?php defined('SYSPATH') or die('No direct access allowed.');

class Context extends Bluebox_Record
{
    public static $errors = array (
        'name' => array (
            'required' => 'Context name is required'
        )
    );
    
    /**
     * Sets the table name, and defines the table columns.
     */
    public function setTableDefinition()
    {
        // COLUMN DEFINITIONS
        $this->hasColumn('context_id', 'integer', 11, array('unsigned' => true, 'notnull' => true, 'primary' => true, 'autoincrement' => true));
        $this->hasColumn('name', 'string', 40, array('notnull' => true, 'notblank' => true));
        $this->hasColumn('locked', 'boolean', NULL, array('default' => false));
    }

    /**
     * Sets up relationships, behaviors, etc.
     */
    public function setUp()
    {
        // RELATIONSHIPS
        $this->hasMany('NumberContext', array('local' => 'context_id', 'foreign' => 'context_id', 'cascade' => array('delete')));

        // BEHAVIORS
        $this->actAs('GenericStructure');
        $this->actAs('Timestampable');
        $this->actAs('MultiTenant');
    }
}