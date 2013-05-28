<?php

require_once dirname(__FILE__).'/../lib/entitlement_packGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/entitlement_packGeneratorHelper.class.php';

/**
 * entitlement_pack actions.
 *
 * @package    sf_sandbox
 * @subpackage entitlement_pack
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class entitlement_packActions extends autoEntitlement_packActions
{
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ServEntitlementPackForm();
    $this->form->setDefault("service_id",$request->getParameter('id'));
    $this->entitlement_pack = $this->form->getObject();
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new ServEntitlementPackForm();
    $this->entitlement_pack = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->entitlement_pack = $this->getRoute()->getObject();
    $this->form = new ServEntitlementPackForm($this->entitlement_pack);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->entitlement_pack = $this->getRoute()->getObject();
    $this->form = new ServEntitlementPackForm($this->entitlement_pack);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? $i18n->__('The entitlement package has been created.') : $i18n->__('The entitlement package has been updated.');

      try {
        $entitlement_pack = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $entitlement_pack)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@entitlement_pack_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect("show/index?id=".$form->getObject()->getServiceId());
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
  
  public function executeDeletea(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $i18n = sfContext::getInstance()->getI18N();
    $r = Doctrine::getTable('EntitlementPack')->find($request->getParameter('id'));
    $os = Doctrine::getTable('Organization')
			->createQuery('o')
                        ->leftJoin('o.OrganizationEntitlementPack oe')
                        ->where('oe.entitlement_pack_id = ?', $r->getId())->execute();
    $sid = $r->getServiceId();

    $this->checkIsMy($r);

    if ($request->getParameter("confirm") != $i18n->__("Yes, do as I say!"))
    {
      $this->getUser()->setFlash('notice', $i18n->__('The entitlement pack has not been deleted.'));
      $this->redirect('show/index?id='.$sid);
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $r)));

    if ($r->delete())
    {
      //Frissítenünk kell a szervezetek szerepköreit, hogy kikerüljenek a már elérhetetlenné vált jogosultságok
      foreach($os as $o){
        foreach($o->getRole() as $role){
	  $role->updateEntitlements($o->getId());
        }
      }
      $this->getUser()->setFlash('notice', $i18n->__('The entitlement pack has been deleted successfully.'));
      
    $to=array();
    //Mail küldése
    foreach($os as $o){
      $to = $o->getManagersEmailArray();
    }
    $to += $r->getService()->getManagersEmailArray();
    
      $mail = $this->getMailer()->compose(ProjectConfiguration::$mail_from, $to, $i18n->__(ProjectConfiguration::$mail_tag.'Entitlement pack %ep% has been deleted from service %service%',array("%ep%"=>$r, "%service%"=>$s)));
      $html  = $this->getPartial('entitlement_pack/deleteEPHtml', array("s"=>$s, "ep"=>$r));
      $mail->setBody($html, 'text/html');

      $this->getMailer()->send($mail);
      
    }
    $this->redirect('show/index?id='.$sid);
  }

  private function checkIsMy($r)
  {
    $i18n = sfContext::getInstance()->getI18N();
    if (! $r->getService()->isMy())
    {
      $m=$i18n->__("You have no rights to access this organization.");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
  }
}
