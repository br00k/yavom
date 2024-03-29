<?php

/**
 * BaseInvitation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $principal_id
 * @property integer $inviter_id
 * @property string $email
 * @property string $uuid
 * @property enum $status
 * @property integer $counter
 * @property timestamp $created_at
 * @property timestamp $accept_at
 * @property timestamp $last_reinvite_at
 * @property integer $organization_id
 * @property integer $role_id
 * @property Role $Role
 * @property Principal $Principal
 * @property Principal $Inviter
 * @property Organization $Organization
 * 
 * @method integer      getId()               Returns the current record's "id" value
 * @method integer      getPrincipalId()      Returns the current record's "principal_id" value
 * @method integer      getInviterId()        Returns the current record's "inviter_id" value
 * @method string       getEmail()            Returns the current record's "email" value
 * @method string       getUuid()             Returns the current record's "uuid" value
 * @method enum         getStatus()           Returns the current record's "status" value
 * @method integer      getCounter()          Returns the current record's "counter" value
 * @method timestamp    getCreatedAt()        Returns the current record's "created_at" value
 * @method timestamp    getAcceptAt()         Returns the current record's "accept_at" value
 * @method timestamp    getLastReinviteAt()   Returns the current record's "last_reinvite_at" value
 * @method integer      getOrganizationId()   Returns the current record's "organization_id" value
 * @method integer      getRoleId()           Returns the current record's "role_id" value
 * @method Role         getRole()             Returns the current record's "Role" value
 * @method Principal    getPrincipal()        Returns the current record's "Principal" value
 * @method Principal    getInviter()          Returns the current record's "Inviter" value
 * @method Organization getOrganization()     Returns the current record's "Organization" value
 * @method Invitation   setId()               Sets the current record's "id" value
 * @method Invitation   setPrincipalId()      Sets the current record's "principal_id" value
 * @method Invitation   setInviterId()        Sets the current record's "inviter_id" value
 * @method Invitation   setEmail()            Sets the current record's "email" value
 * @method Invitation   setUuid()             Sets the current record's "uuid" value
 * @method Invitation   setStatus()           Sets the current record's "status" value
 * @method Invitation   setCounter()          Sets the current record's "counter" value
 * @method Invitation   setCreatedAt()        Sets the current record's "created_at" value
 * @method Invitation   setAcceptAt()         Sets the current record's "accept_at" value
 * @method Invitation   setLastReinviteAt()   Sets the current record's "last_reinvite_at" value
 * @method Invitation   setOrganizationId()   Sets the current record's "organization_id" value
 * @method Invitation   setRoleId()           Sets the current record's "role_id" value
 * @method Invitation   setRole()             Sets the current record's "Role" value
 * @method Invitation   setPrincipal()        Sets the current record's "Principal" value
 * @method Invitation   setInviter()          Sets the current record's "Inviter" value
 * @method Invitation   setOrganization()     Sets the current record's "Organization" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseInvitation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('invitation');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('principal_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('inviter_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('uuid', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'pending',
              1 => 'accepted',
             ),
             'notnull' => true,
             ));
        $this->hasColumn('counter', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('created_at', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('accept_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('last_reinvite_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('organization_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('role_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Role', array(
             'local' => 'role_id',
             'foreign' => 'id'));

        $this->hasOne('Principal', array(
             'local' => 'principal_id',
             'foreign' => 'id'));

        $this->hasOne('Principal as Inviter', array(
             'local' => 'inviter_id',
             'foreign' => 'id'));

        $this->hasOne('Organization', array(
             'local' => 'organization_id',
             'foreign' => 'id'));
    }
}