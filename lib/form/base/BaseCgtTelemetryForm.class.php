<?php

/**
 * CgtTelemetry form base class.
 *
 * @method CgtTelemetry getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseCgtTelemetryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'sql'        => new sfWidgetFormTextarea(),
      'active'     => new sfWidgetFormInputCheckbox(),
      'created_by' => new sfWidgetFormInputText(),
      'updated_by' => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateJQueryUI(),
      'updated_at' => new sfWidgetFormDateJQueryUI(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 255)),
      'sql'        => new sfValidatorString(),
      'active'     => new sfValidatorBoolean(),
      'created_by' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_by' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new cgtValidatorDate(),
      'updated_at' => new cgtValidatorDate(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'CgtTelemetry', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('cgt_telemetry[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
    
    // 2z -> aggiunto unset created_at, updated_at
    unset($this['created_at']);
    unset($this['updated_at']);
  }
  
  /**
   * Constructor.
   *
   * @param mixed  A object used to initialize default values
   * @param array  An array of options
   * @param string A CSRF secret (false to disable CSRF protection, null to use the global CSRF secret)
   *
   * @see sfForm
   */
  public function __construct($object = null, $options = array(), $CSRFSecret = null)
  {
    parent::__construct($object, $options, $CSRFSecret);
    
     // 2z -> aggiunta chiamata a metodo per lo show
    $this->switchToShow();
  }
  
  // 2z -> aggiunto metodo per lo show
  public function switchToShow() 
  {
    $mode = array_key_exists('mode', $this->options) ? $this->options['mode'] : 'edit';

    if($mode == 'show')
    {
        $positions = $this->widgetSchema->getPositions();
        $widgets = widgetModeSwitcher::switchSet($this->widgetSchema);
        $this->setWidgets($widgets);
        $this->widgetSchema->setPositions($positions);
    }
    
  }

  public function getModelName()
  {
    return 'CgtTelemetry';
  }


}
