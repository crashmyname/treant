<?php

class Validator {
    protected $errors = [];

    public function validate($data, $rules) {
        foreach ($rules as $field => $rule) {
            $ruleSet = explode('|', $rule);
            foreach ($ruleSet as $r) {
                $method = 'validate' . ucfirst($r);
                if (method_exists($this, $method)) {
                    $this->$method($field, $data[$field] ?? null);
                } elseif (strpos($r, ':') !== false) {
                    list($ruleName, $parameter) = explode(':', $r);
                    $method = 'validate' . ucfirst($ruleName);
                    if (method_exists($this, $method)) {
                        $this->$method($field, $data[$field] ?? null, $parameter);
                    }
                }
            }
        }

        return $this->errors;
    }

    protected function validateRequired($field, $value) {
        if (is_null($value) || $value === '') {
            $this->errors[$field][] = "$field is required.";
        }
    }

    protected function validateMin($field, $value, $min) {
        if (strlen($value) < $min) {
            $this->errors[$field][] = "$field must be at least $min characters.";
        }
    }

    protected function validateMax($field, $value, $max) {
        if (strlen($value) > $max) {
            $this->errors[$field][] = "$field must be no more than $max characters.";
        }
    }

    protected function validateNumeric($field, $value) {
        if (!is_numeric($value)) {
            $this->errors[$field][] = "$field must be a number.";
        }
    }
}
?>