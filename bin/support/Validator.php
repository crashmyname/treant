<?php
namespace Support;

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

    protected function validateEmail($field, $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field must be a valid email address.";
        }
    }
    
    protected function validateConfirmed($field, $value, $confirmationField) {
        if ($value !== $_POST[$confirmationField]) {
            $this->errors[$field][] = "$field must match $confirmationField.";
        }
    }

    protected function validateAge($field, $value, $minAge) {
        $currentYear = date('Y');
        $birthYear = date('Y', strtotime($value));
        $age = $currentYear - $birthYear;
        
        if ($age < $minAge) {
            $this->errors[$field][] = "$field must be at least $minAge years old.";
        }
    }

    protected function validateRegex($field, $value, $pattern) {
        if (!preg_match($pattern, $value)) {
            $this->errors[$field][] = "$field does not match the required format.";
        }
    }
    
    protected function validateFileSize($field, $file, $maxSize) {
        if ($file['size'] > $maxSize) {
            $this->errors[$field][] = "$field must not exceed " . ($maxSize / 1024) . " KB.";
        }
    }

    protected function validateDate($field, $value, $format) {
        $d = DateTime::createFromFormat($format, $value);
        if (!$d || $d->format($format) !== $value) {
            $this->errors[$field][] = "$field must be a valid date in the format $format.";
        }
    }

    protected function validateAlphanumeric($field, $value) {
        if (!ctype_alnum($value)) {
            $this->errors[$field][] = "$field must be alphanumeric.";
        }
    }

    protected function validateImage($field, $file, $allowedTypes = [], $maxSize = null, $minWidth = null, $minHeight = null) {
        // Validasi ukuran file jika parameter $maxSize diberikan
        if ($maxSize !== null) {
            $this->validateFileSize($field, $file, $maxSize);
        }
    
        // Validasi tipe file jika parameter $allowedTypes diberikan
        if (!empty($allowedTypes)) {
            $this->validateFileType($field, $file, $allowedTypes);
        }
    
        // Validasi dimensi gambar jika parameter $minWidth dan $minHeight diberikan
        if ($minWidth !== null || $minHeight !== null) {
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo) {
                list($width, $height) = $imageInfo;
                if ($minWidth !== null && $width < $minWidth) {
                    $this->errors[$field][] = "$field must be at least $minWidth pixels wide.";
                }
                if ($minHeight !== null && $height < $minHeight) {
                    $this->errors[$field][] = "$field must be at least $minHeight pixels tall.";
                }
            } else {
                $this->errors[$field][] = "$field must be a valid image.";
            }
        }
    }    
    
    protected function validateFileType($field, $file, $allowedTypes) {
        $fileType = mime_content_type($file['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $this->errors[$field][] = "$field must be one of the following types: " . implode(', ', $allowedTypes) . ".";
        }
    }
        
}
?>