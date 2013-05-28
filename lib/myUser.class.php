<?php

class myUser extends sfGuardSecurityUser
{
  public function getPrincipal()
  {
     $p=Doctrine::getTable('Principal')->findOneByFedid($this->getUsername());
     return $p;
  }
  public function getPrincipalId()
  {
     $p=$this->getPrincipal();
     return $p->getId();
  }
  
  public function isFirstRequest($boolean = null)
  {
    if (is_null($boolean))
    {
      return $this->getAttribute('first_request', true);
    }
 
    $this->setAttribute('first_request', $boolean);
  }
  
}
