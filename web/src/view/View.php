<?php
/**
 * Dylan Cross ID 15219491
 * Jordan Felix ID 15152699
 * Thomas Sloman ID 15078758
 */

/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 30/08/17
 * Time: 4:38 PM
 */

namespace agilman\a2\view;

/**
 * Class View
 *
 * A wrapper for the view templates.
 * Limits the accessible scope available to phtml templates.
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class View
{

    /**
     * @var string path to template being rendered
     */
    protected $template = null;

    /**
     * @var array data to be made available to the template
     */
    protected $data = array();

    public function __construct($template) {
        try {
            $file =  APP_ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . '.phtml';

            if (file_exists($file)) {
                $this->template = $file;
            } else {
//                throw new customException('Template ' . $template . ' not found!');
            }
        }
        catch (customException $e) {
            echo $e->errorMessage();
        }
    }

    /**
     * Adds a key/value pair to be available to phtml template
     *
     * @param $key name of the data to be available
     * @param $val value of the data to be available
     *
     * @return $this View
     */
    public function addData($key, $val) {
        $this->data[$key] = $val;
        return $this;
    }

    /**
     * Render the template, returning it's content.
     *
     * @return string The rendered template.
     */
    public function render() {
        extract($this->data);

        ob_start();
        include($this->template);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}