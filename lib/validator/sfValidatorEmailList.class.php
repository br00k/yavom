<?php
class sfValidatorEmailList extends sfValidatorEmail
{
 
  /**
   * @see sfValidatorEmail
   */
    protected function configure($options = array(), $messages = array())
    {
        parent::configure($options, $messages);
 
        $this->addOption('separator', ',');
    }
 
  /**
   * @see sfValidatorString
   */
    public function doClean($value)
    {
        $retVal = array();
        $valueError = array();
        $mails = explode($this->getOption('separator'), $value);
 
        foreach ($mails as $mail)
        {
            try
            {
                $retVal[] = parent::doClean(trim($mail));
            }
            catch (sfValidatorError $e)
            {
                $valueError[] = $e->getValue();
            }
        }
 
        if ( ! empty ($valueError) )
        {
            throw new sfValidatorError($this, 'invalid', array('value' => implode(', ', $valueError)));
        }
 
        return $retVal;
    }
 
}
