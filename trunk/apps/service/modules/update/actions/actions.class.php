<?php

/**
 * update actions.
 *
 * @package    sf_sandbox
 * @subpackage update
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class updateActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->s = Doctrine::getTable('Service')->find($request->getParameter('id'));
    if (! $this->s->isMy())
    {
      // TODO
    }
    $this->form = new ServiceForm($this->s);
    $this->form->useFields(array("name","entityId","url","description","type","token"));
    
  }
}
