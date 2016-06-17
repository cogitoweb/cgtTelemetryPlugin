<?php

/**
 * CgtTelemetry filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseCgtTelemetryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sql'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'active'     => new sfWidgetFormChoice(array('choices' => array('' => 'qualsiasi', 1 => 'si', 0 => 'no'))),
      'created_by' => new sfWidgetFormFilterInput(),
      'updated_by' => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array(), array('placeholder' => sfContext::getInstance()->getI18N()->__('from mm/dd/yyyy'))), 
        		'to_date' => new sfWidgetFormDateJQueryUI(array(), array('placeholder' => sfContext::getInstance()->getI18N()->__('to mm/dd/yyyy'))), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array(), array('placeholder' => sfContext::getInstance()->getI18N()->__('from mm/dd/yyyy'))), 
        		'to_date' => new sfWidgetFormDateJQueryUI(array(), array('placeholder' => sfContext::getInstance()->getI18N()->__('to mm/dd/yyyy'))), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'sql'        => new sfValidatorPass(array('required' => false)),
      'active'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_by' => new sfValidatorPass(array('required' => false)),
      'updated_by' => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new cgtValidatorDate(array('required' => false)), 'to_date' => new cgtValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new cgtValidatorDate(array('required' => false)), 'to_date' => new cgtValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('cgt_telemetry_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CgtTelemetry';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'sql'        => 'Text',
      'active'     => 'Boolean',
      'created_by' => 'Text',
      'updated_by' => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
