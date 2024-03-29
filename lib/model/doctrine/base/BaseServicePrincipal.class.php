<?php

/**
 * BaseServicePrincipal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $service_id
 * @property integer $principal_id
 * @property Service $Service
 * @property Principal $Principal
 * 
 * @method integer          getId()           Returns the current record's "id" value
 * @method integer          getServiceId()    Returns the current record's "service_id" value
 * @method integer          getPrincipalId()  Returns the current record's "principal_id" value
 * @method Service          getService()      Returns the current record's "Service" value
 * @method Principal        getPrincipal()    Returns the current record's "Principal" value
 * @method ServicePrincipal setId()           Sets the current record's "id" value
 * @method ServicePrincipal setServiceId()    Sets the current record's "service_id" value
 * @method ServicePrincipal setPrincipalId()  Sets the current record's "principal_id" value
 * @method ServicePrincipal setService()      Sets the current record's "Service" value
 * @method ServicePrincipal setPrincipal()    Sets the current record's "Principal" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseServicePrincipal extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('service_principal');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('service_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('principal_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Service', array(
             'local' => 'service_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Principal', array(
             'local' => 'principal_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}