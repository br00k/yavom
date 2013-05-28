<?php

require_once dirname(__FILE__).'/../lib/entitlementGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/entitlementGeneratorHelper.class.php';

/**
 * entitlement actions.
 *
 * @package    sf_sandbox
 * @subpackage entitlement
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class entitlementActions extends autoEntitlementActions
{
  public function executeNew(sfWebRequest $request)
  {
    $s = Doctrine::getTable('Service')->find($request->getParameter('id'));
    $this->form = new ServEntitlementForm();
    $this->form->setDefault("service_id",$s->getId());
    $this->form->setDefault("uri",$s->getEntitlementPrefix().':');
    $this->entitlement = $this->form->getObject();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new ServEntitlementForm();
    $this->entitlement = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->entitlement = $this->getRoute()->getObject();
    $this->form = new ServEntitlementForm($this->entitlement);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->entitlement = $this->getRoute()->getObject();
    $this->form = new ServEntitlementForm($this->entitlement);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $i18n = sfContext::getInstance()->getI18N();
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $s = Doctrine::getTable('Service')->find($form->getValue('service_id'));
    $form->setValidator['uri'] = new sfValidatorRegex(
    		array(
    				'pattern' => '/^'.$s->getEntitlementPrefix().':.*$/',
    				)
    		);
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? $i18n->__('The entitlement has been created.') : $i18n->__('The entitlement has been updated');

      try {
        $entitlement = $form->save();
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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $entitlement)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@entitlement_new');
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
    $e = Doctrine::getTable('Entitlement')->find($request->getParameter('id'));
    $sid = $e->getServiceId();

    $this->checkIsMy($e);

    if ($request->getParameter("confirm") != $i18n->__("Yes, do as I say!"))
    {
      $this->getUser()->setFlash('notice', $i18n->__('The entitlement has not been deleted.'));
      $this->redirect('show/index?id='.$sid);
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $e)));

    if ($e->delete())
    {
      $this->getUser()->setFlash('notice', $i18n->__('The entitlement has been deleted successfully.'));
    }
    $this->redirect('show/index?id='.$sid);
  }

  private function checkIsMy($e)
  {
    $i18n = sfContext::getInstance()->getI18N();
    if (! $e->getService()->isMy())
    {
      $m=$i18n->__("You have no rights to access this organization.");
      $this->getUser()->setFlash('error',$m);
      $this->redirect("default/error");
    }
  }

}
