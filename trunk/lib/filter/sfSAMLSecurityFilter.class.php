<?php

class sfSAMLSecurityFilter extends sfFilter
{
  /**
   * Executes this filter.
   *
   * @param sfFilterChain $filterChain A sfFilterChain instance
   */
  public function execute($filterChain)
  {
    // disable security on login and secure actions
/*
    if (
      (sfConfig::get('sf_login_module') == $this->context->getModuleName()) && (sfConfig::get('sf_login_action') == $this->context->getActionName())
      ||
      (sfConfig::get('sf_secure_module') == $this->context->getModuleName()) && (sfConfig::get('sf_secure_action') == $this->context->getActionName())
    )
    {
      $filterChain->execute();

      return;
    }
*/
    if ($this->context->getUser()->isAuthenticated())
    {
      $as = new SimpleSAML_Auth_Simple('default-sp');
      if (!$as->isAuthenticated())
        $this->context->getUser()->setAuthenticated(FALSE);
    }


    // the user has access, continue
    $filterChain->execute();
  }

}
