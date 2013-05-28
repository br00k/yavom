<?php

/**
 * Service
 * 
 * Registered services in YAVOM.
 * 
 * @author     gyufi@sztaki.hu
 */
class Service extends BaseService
{
  /**
  * The user is owner of this service? Test function for authorizing purposes.
  * @return boolean
  */
  public function isMy(){
    $p = Doctrine_Query::create()
                        ->from('Principal p')
                        ->leftJoin('p.ServicePrincipal sp')
                        ->leftJoin('sp.Service s')
                        ->where('s.id = ?', $this->getId())->execute();
    foreach($p as $pf){
      if (sfContext::getInstance()->getUser()->getUsername() == $pf->getFedid()){
	    return TRUE;
      }
    }
  /*
    if (sfContext::getInstance()->getUser()->getUsername() == $this->getPrincipal()->getFedid()){
      return TRUE;
    }*/
    return FALSE;
  }

  /**
   * Return true if the service has pending subscription requests from any VO.
   * 
   * @return boolean
   */
  public function hasPendingOrganization(){
    $q = Doctrine_Query::create()
                        ->from('OrganizationEntitlementPack oep')
                        ->leftJoin('oep.EntitlementPack ep')
                        ->leftJoin('ep.Service s')
                        ->where('s.id = ?', $this->getId())->execute();
    foreach ($q as $ep){
      if ($ep->getStatus() == "pending"){
        return TRUE;
      }
    }
    return FALSE;
  }
  
  /**
   * Return the managers' principal objects in an array.
   * 
   * @return array
   */
  public function getManagers(){
    $p = Doctrine_Query::create()
                        ->from('Principal p')
                        ->leftJoin('p.ServicePrincipal sp')
                        ->leftJoin('sp.Service s')
                        ->where('s.id = ?', $this->getId())->execute();
    return $p;
  }
  
  public function getManagersEmailArray(){
    $managers = $this->getManagers();
    $mails = array();
    foreach($managers as $manager){
      $mails[$manager->getEmail()]=$manager->getName();
    }
    return $mails;
  }
  
  /**
   * Return the email addresses of the managers in an array, where the keys are the e-mail addresses,
   * the values are the matching names.
   * 
   * @return array
   */
  public function getEntitlementPrefix(){  	
    $vo_prefix = 'urn:geant:niif.hu:sztaki:';
    $unaccentname = Doctrine_Inflector::urlize($this->getName());
    return $vo_prefix.$unaccentname;
  }
  
  /**
   * Return the validated status of the service.
   * @return boolean
   */
  public function isValidated(){  	
  	$type = $this->getType();  	
  	return $type == 'valid';
  }
  
}
