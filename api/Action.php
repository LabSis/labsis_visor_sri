<?php

require_once './api_config.php';

abstract class Action {

    private static $STATUS_ERROR = "NO";
    private static $STATUS_OK = "OK";
    private $_result_status;
    private $_result_message;
    private $_result_data;
    private $_required_post;
    private $_required_get;

    public function __construct($required_get, $required_post) {
        $this->_result_status = "OK";
        $this->_result_message = "";
        $this->_result_data = array();
        $this->_required_get = $required_get;
        $this->_required_post = $required_post;
    }

    protected abstract function execute_action();

    public function set_required_parameters_get($parameters_array) {
        $this->_required_get = $parameters_array;
    }

    public function set_required_parameters_post($parameters_array) {
        $this->_required_post = $parameters_array;
    }

    public function add_data($key, $data){
        $this->_result_data[$key] = $data;
    }
    
    public function execute() {
        if (!$this->validate_parameters()) {
            return false;
        } else {
            return $this->execute_action();
        }
    }

    private function validate_parameters() {
        $missed_parameters = array();

        if (!is_null($this->_required_get)) {
            foreach ($this->_required_get as $parameter) {
                $p = filter_input(INPUT_GET, $parameter);
                if (is_null($p)) {
                    $missed_parameters[] = $parameter;
                }
            }
        }
        if (!is_null($this->_required_post)) {
            foreach ($this->_required_post as $parameter) {
                $p = filter_input(INPUT_POST, $parameter);
                if (is_null($p)) {
                    $missed_parameters[] = $parameter;
                }
            }
        }

        $count_missed_parameters = count($missed_parameters);
        if ($count_missed_parameters > 0) {
            $message = "";
            foreach ($missed_parameters as $mp) {
                $message .= $mp;
            }
            $message .= ($count_missed_parameters > 1 ) ? ' are required.' : ' is required.';

            $this->set_error($message);
            return false;
        } else {
            return true;
        }
    }

    function get_result_json() {
        $result = array();
        $result['status'] = $this->_result_status;
        $result['message'] = $this->_result_message;
        $result['data'] = $this->_result_data;
        return json_encode($result);
    }

    function set_error($message) {
        $this->_result_status = Action::$STATUS_ERROR;
        $this->set_message($message);
    }

    function set_ok($message) {
        $this->_result_status = Action::$STATUS_OK;
        $this->set_message($message);
    }

    private function set_message($message) {
        $this->_result_message = $message;
    }

}

class AnalizeDomainAction extends Action {

    public function __construct() {
        $required_get = ["url"];
        $required_post = null;
        parent::__construct($required_get, $required_post);
    }

    public function execute_action() {
        $url = filter_input(INPUT_GET, "url");

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->set_error("Invalid url.");
        } else {
            global $SRI_PATH;
            $analysis_result = array();            
            $command = "java -jar " . $SRI_PATH . " " . $url;
            exec($command, $analysis_result);

            try {
                $analysis_result = json_decode(join("", $analysis_result));
                
                $this->add_data('tags', $analysis_result->resultadosTags);               
                $this->add_data('classification', $analysis_result->clasificacion);                
                $this->add_data('url', $analysis_result->url);

                $this->set_ok("");                
            } catch (Exception $ex) {
                $this->set_error("An error has occurred.");                
            }
        }
    }

}

class DefaultAction extends Action {

    public function __construct() {
        $required_get = null;
        $required_post = null;
        $http_method = $_SERVER['REQUEST_METHOD'];

        if ($http_method == "GET") {
            $required_get = ['action'];
        } else if ($http_method == "POST") {
            $required_post = ['action'];
        }
        parent::__construct($required_get, $required_post);
    }

    public function execute_action() {
        $this->set_ok("I'm fine :)");
    }

}
