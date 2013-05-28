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
  if (!$request->getParameter('sf_culture'))
  {
    $ssaml = new SimpleSAML_Auth_Simple('default-sp');
    $attributes = $ssaml->getAttributes();
    //die(var_dump($attributes['preferredLanguage']));
    if ($this->getUser()->isFirstRequest())
    {
      if (array_key_exists('preferredLanguage', $attributes)) 
      {
        $culture = $attributes['preferredLanguage'];
        if ($culture != 'hu' && $culture != 'en')
        {
          $culture = $request->getPreferredCulture(array('hu', 'en'));
        }
      } else {
        $culture = $request->getPreferredCulture(array('hu', 'en'));
      }
      $this->getUser()->setCulture($culture);
      $this->getUser()->isFirstRequest(false);
    }
    else
    {
      $culture = $this->getUser()->getCulture();
    }
 
    $this->redirect('localized_homepage');
  }
  }

  public function executeError()
  {
  }
  
  public function executeError404()
  {
  $this->redirect('homepage');
  }

}
