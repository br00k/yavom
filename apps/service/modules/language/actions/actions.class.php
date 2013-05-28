<?php

/**
 * language actions.
 *
 * @package    sf_sandbox
 * @subpackage language
 * @author     gyufi@sztaki.hu
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class languageActions extends sfActions
{
 /** 
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  
  public function executeSwitch(sfWebRequest $request)
  {
    $referer = $request->getReferer();
    if ($request->hasParameter("lang")) { 
      $lang=$request->getParameter('lang');
    } else {
      $lang = $request->getPreferredCulture(array('en', 'hu'));
    }
    
    if ($lang != 'en' && $lang!='hu') 
    {
      $lang = $request->getPreferredCulture(array('en', 'hu'));
    }
    
    $this->getUser()->setCulture($lang);
    
     
    $pos = strpos($referer, '/hu/');
    if ($pos === false){
      $pos = strpos($referer, '/en/');
        if ($pos === false){
          $whereto = false;
          } else {
          $eleje = substr($referer, 0, $pos);
          $whereto=substr($referer, $pos+4);
          }
    } else {
      $eleje = substr($referer, 0, $pos);
      $whereto=substr($referer, $pos+4);
    }
    
    if (!$whereto) 
    {
      $this->redirect('localized_homepage');
    } else {
      $this->redirect($eleje."/".$lang."/".$whereto);
    }
    
    
  }
  
}
