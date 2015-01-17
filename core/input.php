<?php
class Input {
    protected $getInput;
    protected $postInput;

    protected $inputFilters;
    protected $filteredInputs;

    public function init() {
        $this->inputFilters['id'] = function($data) { return intval($data); }
    }

    public function update() {
        self::$getInput = $_GET;
        self::$postInput = $_POST;

        self::filterInputs(self::$getInput);
        self::filterInputs(self::$postInput);
    }

    public function addInputFilter($filterName, $filterFunc) {
        self::$inputFilters[$filterName] = $filterFunc;
    }

    public function addFilteredInput($inputName, $filterName) {
        self::$filteredInputs[$inputName] = $filterName;
    }

    public function get($inputName, $type = 'POST') {
        $type = strtoupper($type);
        if($type == 'GET') {
            if(array_key_exists($inputName, self::$getInput))
                return self::$getInput[$inputName];
            else if(array_key_exists($inputName, self::$postInput))
                return self::$postInput[$inputName];
        }
        else {
            if(array_key_exists($inputName, self::$postInput))
                return self::$postInput[$inputName];
            else if(array_key_exists($inputName, self::$getInput))
                return self::$getInput[$inputName];
        }
        return null;
    }

    protected function filterInputs($data) {
        foreach(self::$filteredInputs as $inputName => $filterName) {
            if(array_key_exists($inputName, $data) && array_key_exists($filterName, self::$inputFilters)) {
                $content = $data[$inputName];
                $filteredContent = call_user_func_array(self::$inputFilters[$filterName], array($content));
                $data[$inputName] = $filteredContent;
            }
        }
    }
}
?>