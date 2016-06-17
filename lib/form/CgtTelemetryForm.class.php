<?php

/**
 * CgtTelemetry form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class CgtTelemetryForm extends BaseCgtTelemetryForm
{
  public function configure()
  {
      unset($this['created_by']);
      unset($this['updated_by']);
  }
}
