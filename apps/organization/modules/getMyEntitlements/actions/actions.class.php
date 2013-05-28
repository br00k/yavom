<?php

/**
 * getMyEntitlements actions.
 *
 * @package    sf_sandbox
 * @subpackage getMyEntitlements
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class getMyEntitlementsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $fedid = $this->getUser()->getGuardUser()->getUserName();
    $this->p = Doctrine::getTable('Principal')->findOneByFedId($fedid);
    $this->os = $this->getUser()->getPrincipal()->getAllRelatedOrganizations();
    
    $rps = Doctrine::getTable('RolePrincipal')->findByPrincipalId($this->p->getId());

    $jogok = array();
    foreach ($rps as $r){
      foreach ($r->getRole()->getEntitlement() as $e){
        //echo 'o: '.$r->getRole()->getOrganization()."; e: ".$e->getName()."; s: ".$e->getService()." ".$e->getService()->getUrl()."<br>";
        $o_id = $r->getRole()->getOrganizationId();
        $e_id = $e->getId();
        $s_id = $e->getServiceId();
        $jogok[$o_id][$e_id] = $e;
      }
    }
    //var_dump(array_keys($jogok));
    $this->jogok = $jogok;
  }
}
