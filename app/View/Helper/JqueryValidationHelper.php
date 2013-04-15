<?php

App::uses('AppHelper', 'View/Helper');

class JqueryValidationHelper extends FormHelper {


  #-- Map to replace constants with jquery and class info
  #-- Pass as $options['jquery-validate']
//  public $options = array(
//      'map' => array(
//          '__formSelector__' => '.jquery-validation',
//          '__errorElement__' => 'span',
//          '__errorClass__' => 'help-block',
//          '__hilightClass__' => 'form-error',
//          '__closestSelector__' => '.control-group',
//          '__closestErrorClass__' => 'error'
//      )
//  );
//  private $validation_messages = array();
//  private $js = "
//    $(document).ready(function(){
//      $('__formSelector__').each( function(index) {
//        $(this).validate({
//          'errorElement': '__errorElement__',
//          'errorClass': '__errorClass__',
//          'highlight': function(element,errorClass) {
//            $(element)
//            .siblings().remove();
//            $(element)
//            .addClass('__hilightClass__')
//            .closest('__closestSelector__').addClass('__closestErrorClass__');
//          },
//          'unhighlight': function(element,errorClass) {
//            $(element)
//            .removeClass('__hilightClass__')
//            .closest('__closestSelector__').removeClass('__closestErrorClass__')
//          },
//        });
//      });
//    });";
//

  public $default_validate_options = array(
    'focusInvalid'=>false,
    'ignore'=>false,
    'errorClass'=>'error-message',
    'errorElement'=>'div',
    'onfocusin'=>false,
    'onfocusout'=>false,
    'onkeyup'=>false,
    'onclick'=>false,
    'highlight'=>'function(element, errorClass, validClass) { return false; }',
    'unhighlight'=>'function(element, errorClass, validClass) { return false; }',
    'rules'=>array(),
    'messages'=>array()
    
  );
  
  public $validate_options = array();
  
    
  /**
   * input
   * 
   * Routine to mimic form helper in order to get needed info.
   * 
   * @param type $fieldName
   * @param type $options - validation options
   */
  public function validationArray($model = null, $options = array()) {
    if (empty($this->defaultModel)) return '';
    $object = $this->_getModel($this->defaultModel);
    $validationRules = $object->validate;
    
    foreach($options as $k=>$value)
      if (!isset($this->default_validate_options[$k])) 
        unset($options[$k]);
    
    foreach($this->default_validate_options as $k=>$v)
      if (isset($options[$k])) 
        unset($this->default_validate_options[$k]);
        
    $this->validate_options = array_merge($this->default_validate_options, $options);
    $js_rules = $js_messages = array();
    foreach($validationRules as $field=>$rule) {
       $field_name = 'data['.$this->defaultModel.']['.$field.']';
       
       if (!is_array($rule)) 
        $rule = array('rule'=>$rule);
       if (!empty($rule['rule'])) 
        $rules[] = $rule;
       else 
        $rules = $rule;
        
       //all rules to this field
       foreach($rules as $rule_options) {
        
          if (isset($rule_options['required']) && $rule_options['required']) {
            $js_rules[$field_name]['require'] = true;
            $js_messages[$field_name]['require'] = '* This field is required';
          }
          if (is_array($rule_options['rule'])){
            
            $rule_main  = $rule_options['rule'][0];
            $rule_from  = @$rule_options['rule'][1];
            $rule_to    = @$rule_options['rule'][2];
          } else {
            $rule_main  = $rule_options['rule'];
          }

          if(!empty($rule_options['message']))
            $js_messages[$field_name][$rule_main] = $rule_options['message'];

          if ($rule_main == 'email') {
            $js_rules[$field_name]['email'] = true;
          }
          if ($rule_main == 'alphaNumeric') {
            $js_rules[$field_name]['alphaNumeric'] = true;
          }
          if ($rule_main == 'between') {
            $js_rules[$field_name]['require'] = true;
            $js_rules[$field_name]['range'] = array($rule_from,$rule_to);
          }
          if ($rule_main == 'equalTo') {
            $js_rules[$field_name]['equalTo'] = $rule_from;
          }
       } 
       unset($rule);
       unset($rules);
    }
    
    $this->validate_options['rules'] = $js_rules;
    $this->validate_options['messages'] = $js_messages;
    
    
    foreach($this->validate_options as $k=>$v) {
      $result_arr[] = $k . ':' . (is_array($v)?json_encode($v):(is_bool($v)?($v?'true':'false'):(substr($v,0,8)=='function'?$v:"'$v'")));
      
    }
    $result = '{'.implode(',',$result_arr).'}';
    return $result;
    //return json_encode($this->validate_options);
  }

  
/**
 *  Various functions to convert a CakePHP validation to a Jquery Validate meta tag
 */
  private function jquery_validate_alphaNumeric($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->date: params=' . print_r($params, true));
    $this->validation_messages[] = "date: '" . $msg . "'";
    return "'date': true";
  }

  private function jquery_validate_between($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->between: params=' . print_r($params, true));
    $this->validation_messages[] = "between: '" . $msg . "'";
    return "'min': " . $params[1] . ", 'max': " . $params[2];
  }

  private function jquery_validate_blank($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->blank: params=' . print_r($params, true));
    $this->validation_messages[] = "rangelength: '" . $msg . "'";
    return "'rangelength': [0, 0]";
  }

  private function jquery_validate_boolean($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->boolean: params=' . print_r($params, true));
    return '';
    $this->validation_messages[] = "boolean: '" . $msg . "'";
    return "'boolean': true";
  }

  private function jquery_validate_cc($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->cc: params=' . print_r($params, true));
    $this->validation_messages[] = "creditcard: '" . $msg . "'";
    return "'creditcard': true";
  }

  private function jquery_validate_comparison($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->comparison: params=' . print_r($params, true));
    $op = $params[1];
    $value = $params[2];
    switch ($op) {
      case '>':
        $value++;
        $this->validation_messages[] = "'min': '" . $msg . "'";
        return "'min': " . $value;
        break;
      case '>=':
        $this->validation_messages[] = "'min': '" . $msg . "'";
        return "'min': " . $value;
        break;
      case '<':
        $value--;
        $this->validation_messages[] = "'max': '" . $msg . "'";
        return "'max': " . $value;
        break;
      case '<=':
        $this->validation_messages[] = "'max': '" . $msg . "'";
        return "'max': " . $value;
        break;
      case '!=':
        $value++;
        $this->validation_messages[] = "'min': '" . $msg . "'";
        $str = "'min': " . $value;
        $value = $value - 2;
        $this->validation_messages[] = "'max': '" . $msg . "'";
        return $str . ", 'max': " . $value;
        break;
      default:
        return '';
    }
  }

  private function jquery_validate_date($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->date: params=' . print_r($params, true));
    $this->validation_messages[] = "date: '" . $msg . "'";
    return "'date': true";
  }

  private function jquery_validate_datetime($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->datetime: params=' . print_r($params, true));
    return '';
    $this->validation_messages[] = "datetime: '" . $msg . "'";
    return "'datetime': true";
  }

  private function jquery_validate_decimal($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->decimal: params=' . print_r($params, true));
    $this->validation_messages[] = "number: '" . $msg . "'";
    return "'number': true";
  }

  private function jquery_validate_email($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->email: params=' . print_r($params, true));
    $this->validation_messages[] = "email: '" . $msg . "'";
    return "'email': true";
  }

  private function jquery_validate_equalTo($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->equalTo: params=' . print_r($params, true));
    $this->validation_messages[] = "equalTo: '" . $msg . "'";
    return "'equalTo': '" . Inflector::camelize($model) . Inflector::camelize($params[1]) . "'";
  }

  private function jquery_validate_extension($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->extension: params=' . print_r($params, true));
    $this->validation_messages[] = "accept: '" . $msg . "'";
    return "'accept': '" . implode($params[1], "|") . "'";
  }

  private function jquery_validate_inList($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->inList: params=' . print_r($params, true));
    return '';
    $this->validation_messages[] = "inList: '" . $msg . "'";
    return "'inList': true";
  }

  private function jquery_validate_ip($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->ip: params=' . print_r($params, true));
    $this->validation_messages[] = "ipv4: '" . $msg . "'";
    return "'ipv4': true";
  }

  private function jquery_validate_luhn($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->luhn: params=' . print_r($params, true));
    return '';
    $this->validation_messages[] = "luhn: '" . $msg . "'";
    return "'luhn': true";
  }

  private function jquery_validate_maxLength($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->maxLength: params=' . print_r($params, true));
    $this->validation_messages[] = "'maxlength': '" . $msg . "'";
    return "'maxlength': " . $params[1];
  }

  private function jquery_validate_minLength($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->minLength: params=' . print_r($params, true));
    $this->validation_messages[] = "'minlength': '" . $msg . "'";
    return "'minlength': " . $params[1];
  }

  private function jquery_validate_money($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->money: params=' . print_r($params, true));
    return '';
    $this->validation_messages[] = "money: '" . $msg . "'";
    return "'money': true";
  }

  private function jquery_validate_notEmpty($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->notEmpty: params=' . print_r($params, true));
    $this->validation_messages[] = "required: '" . $msg . "'";
    return "'required': true";
  }

  private function jquery_validate_numeric($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->numeric: params=' . print_r($params, true));
    $this->validation_messages[] = "number: '" . $msg . "'";
    return "'number': true";
  }

  private function jquery_validate_naturalNumber($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->naturalNumber: params=' . print_r($params, true));
    $this->validation_messages[] = "digits: '" . $msg . "'";
    return "'digits': true";
  }

  private function jquery_validate_required($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->required: params=' . print_r($params, true));
    $this->validation_messages[] = "required: '" . $msg . "'";
    return "'required': true";
  }

  private function jquery_validate_phone($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->phone: params=' . print_r($params, true));
    $this->validation_messages[] = "phoneUS: '" . $msg . "'";
    return "'phoneUS': true";
  }

  private function jquery_validate_postal($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->postal: params=' . print_r($params, true));
    $this->validation_messages[] = "minlength: '" . $msg . "'";
    $this->validation_messages[] = "maxlength: '" . $msg . "'";
    return "'minlength': 5, 'maxlength': 5";
  }

  private function jquery_validate_range($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->range: params=' . print_r($params, true));
    $this->validation_messages[] = "min: '" . $msg . "'";
    $this->validation_messages[] = "max: '" . $msg . "'";
    return "'min': " . $params[1] . ", 'max': " . $params[2];
  }

  private function jquery_validate_ssn($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->ssn: params=' . print_r($params, true));
    $this->validation_messages[] = "minlength: '" . $msg . "'";
    $this->validation_messages[] = "maxlength: '" . $msg . "'";
    return "'minlength': 9, 'maxlength': 9";
  }

  private function jquery_validate_time($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->time: params=' . print_r($params, true));
    $this->validation_messages[] = "time: '" . $msg . "'";
    return "'time': true";
  }

  private function jquery_validate_url($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->url: params=' . print_r($params, true));
    $this->validation_messages[] = "url: '" . $msg . "'";
    return "'url': true";
  }

  private function jquery_validate_uuid($model, $field, $params, $msg) {
    CakeLog::write('debug', 'JqueryValidate->uuid: params=' . print_r($params, true));
    return '';
    $this->validation_messages[] = "uuid: '" . $msg . "'";
    return "'uuid': true";
  }
}