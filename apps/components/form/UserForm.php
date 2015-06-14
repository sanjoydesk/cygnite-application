<?php 
namespace Apps\Components\Form;

use Cygnite\FormBuilder\Form;
use Cygnite\Foundation\Application;
use Cygnite\Common\UrlManager\Url;

/**
* Sample Form using Cygnite Form Builder
* This file generated by Cygnite CLI Generator.
* You may alter the code to fit your needs
*/

class UserForm extends Form
{
    //set model object
    private $model;

    public $errors;

    private $segment;

    //set validator object
    public $validation;

    // We will set action url
    public $action = 'add';

    public function __construct($object = null, $segment = null)
    {
        // your model object
        $this->model = $object;
        $this->segment = $segment;
    }

    /**
     *  Build form and return object
     * @return ProductForm
     */
    public function buildForm()
    {
        $id = (isset($this->model->id)) ? $this->model->id : '';

        // Fllowing code is to display validation errors below the input box
        if (is_object($this->validation)) {
            $this->validator = $this->validation;// Errors will displayed below to inputs
            // Set your custom errors
            //$this->validator->setCustomError('column_name_error', 'Custom Error');
        }

        $this->open("ProductController", array(
        "method" => "post", "id"     => "uniform", "role"   => "form", "action" => Url::sitePath("product/$this->action/$id/"),
        "style" => "width:500px;margin-top:35px;float:left;" )
        )		->addElement("label", "Product Name", array("class" => "col-sm-2 control-label","style" => "width:100%;"))
		->addElement("text", "product_name", array("value" => (isset($this->model->product_name)) ? $this->model->product_name : "", "class" => "form-control"))
		->addElement("label", "Category", array("class" => "col-sm-2 control-label","style" => "width:100%;"))
		->addElement("text", "category", array("value" => (isset($this->model->category)) ? $this->model->category : "", "class" => "form-control"))
		->addElement("label", "Description", array("class" => "col-sm-2 control-label","style" => "width:100%;"))
		->addElement("text", "description", array("value" => (isset($this->model->description)) ? $this->model->description : "", "class" => "form-control"))
		->addElement("label", "Validity", array("class" => "col-sm-2 control-label","style" => "width:100%;"))
		->addElement("text", "validity", array("value" => (isset($this->model->validity)) ? $this->model->validity : "", "class" => "form-control"))
		->addElement("label", "Price", array("class" => "col-sm-2 control-label","style" => "width:100%;"))
		->addElement("text", "price", array("value" => (isset($this->model->price)) ? $this->model->price : "", "class" => "form-control"))
		->addElement("label", "Created At", array("class" => "col-sm-2 control-label","style" => "width:100%;"))
		->addElement("text", "created_at", array("value" => (isset($this->model->created_at)) ? $this->model->created_at : "", "class" => "form-control"))
		->addElement("label", "Updated At", array("class" => "col-sm-2 control-label","style" => "width:100%;"))
		->addElement("text", "updated_at", array("value" => (isset($this->model->updated_at)) ? $this->model->updated_at : "", "class" => "form-control"))
		->addElement("submit", "btnSubmit", array("value" => "Save", "class" => "btn btn-primary", "style" => "margin-top:15px;" ))
		->close()
		->createForm();



        return $this;
    }

    /**
     * Render form
     * @return type
     */
    public function render()
    {
        return $this->getForm();
    }
}