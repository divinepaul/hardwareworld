<?php

class Input {
    public string $type = "text";
    public string $id;
    public string $name;
    public string $label;
    public string $placeholder;
    public string $value;
    public string $mysqli_type = "s";
    public $selectOptions = array();
    public $errors = array();
    public $minLength = INF;
    public bool $blank = false;
    public $maxLength = INF;

    public function __construct($name,$label,$maxLength=INF,$minLength=INF,$type="text",$mysqli_type="s"){
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = &$this->label;
        $this->value = "";
        $this->mysqli_type = $mysqli_type;
        $this->maxLength = $maxLength;
        $this->minLength = $minLength;
    }

    public function validate() {
        if( !$this->blank &&
            isset($this->value) &&
            empty(trim($this->value))) {

            array_push($this->errors,"{$this->label} cannot be empty.");
        }
        if( $this->minLength != INF &&
            strlen($this->value) < $this->minLength ) {

            array_push($this->errors,"{$this->label} cannot be less than {$this->minLength} characters.");
        }
        if($this->maxLength != INF &&
            strlen($this->value) > $this->maxLength ) {

            array_push($this->errors,"{$this->label} cannot exceed {$this->maxLength} characters.");
        }
        if($this->type == "email" && !filter_var($this->value, FILTER_VALIDATE_EMAIL)){
            array_push($this->errors,"Not a valid email");
        }
        if(count($this->errors)) {
            return false;
        } else {
            return true;
        }

    }
    public function render() {
        echo "<label for=\"{$this->name}\">{$this->label}</label>";
        if ($this->type!="text" && $this->type == "select") {
            echo "<select name=\"{$this->name}\" >";
            foreach ($this->selectOptions as $value => $label) {
                $isSelected = $value == $this->value ? "selected=true" : null; 

                echo "<option value=\"{$value}\" {$isSelected} >{$label}</option>";
            }
            echo "</select><br><br>";
        } else if($this->type!="text" && $this->type == "textarea") {
            echo "<textarea name=\"{$this->name}\" placeholder=\"{$this->placeholder}\">{$this->value}</textarea>";
        } else { 
            echo "<input type=\"{$this->type}\" value=\"{$this->value}\" name=\"{$this->name}\" placeholder=\"{$this->placeholder}\"  />";
        }
        foreach ($this->errors as $i => $error) {
            echo "<p class=\"error\">{$error}</p>";
        }
    }

}

?>

