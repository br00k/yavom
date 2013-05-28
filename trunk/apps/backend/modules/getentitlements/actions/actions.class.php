<?php

/**
 * getentitlements actions.
 *
 * @package    sf_sandbox
 * @subpackage getentitlements
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class getentitlementsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new GetEntitlementsForm();
    if ($request->isMethod('post'))
    {
      //$this->form->bind(array($request->getParameter('getentitlements')));
      $this->form->bind(array('_csrf_token' => $request->getParameter('_csrf_token'),
                              'service_id'=>$request->getParameter('service_id'),
                              'principal_id'=>$request->getParameter('principal_id'),
	));
      if ($this->form->isValid())
      {
        $this->p = Doctrine::getTable('Principal')->find($request->getParameter('principal_id'));
        $this->s = Doctrine::getTable('Service')->find($request->getParameter('service_id'));
        $ar = new AttributeResolver();
        $es = $ar->getEntitlementsForPrincipalToService($this->p,$this->s);
        $this->es = $es;

        $uris = $ar->getUrisForEppnToSpid($this->p->getFedid(),$this->s->getEntityId());
        $this->uris = $uris;
      }
    }
  }
}
