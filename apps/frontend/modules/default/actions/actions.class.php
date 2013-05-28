<?php

/**
 * default actions.
 *
 * @package    sf_sandbox
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    // Elküldjük az organization.php-ra, amíg nincs portál
    //$url=$request->getUriPrefix().$request->getRelativeUrlRoot()."/organization.php";
    //$this->redirect($url);
  }
  public function executeLogout(sfWebRequest $request)
  {
  }
}
