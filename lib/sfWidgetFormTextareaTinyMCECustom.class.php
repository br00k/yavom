<?php
class sfWidgetFormTextareaTinyMCECustom extends sfWidgetFormTextarea
{
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $textarea = parent::render($name, $value, $attributes, $errors);
 
    $js = sprintf(<<<EOF
<script type="text/javascript">
  tinyMCE.init({
    mode:                              "exact",
    elements:                          "%s",
    theme:                             "advanced",
    %s
    %s
    theme_advanced_toolbar_location:   "top",
    theme_advanced_toolbar_align:      "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing:           false,
    theme_advanced_buttons1 : "bold,italic,separator,bullist,numlist,separator,undo,redo,separator,link",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    %s
  });
</script>
EOF
    ,
      $this->generateId($name),
      $this->getOption('width')  ? sprintf('width:                             "%spx",', $this->getOption('width')) : '',
      $this->getOption('height') ? sprintf('height:                            "%spx",', $this->getOption('height')) : '',
      $this->getOption('config') ? ",\n".$this->getOption('config') : ''
    );
 
    return $textarea.$js;
  }
 
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('theme', 'advanced');
    $this->addOption('width');
    $this->addOption('height');
    $this->addOption('config', '');
  }
 
}
