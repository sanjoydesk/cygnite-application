<?php
namespace Apps\Controllers;

use Cygnite\Common\Input\Input;
use Cygnite\FormBuilder\Form;
use Cygnite\Validation\Validator;
use Cygnite\Common\UrlManager\Url;
use Cygnite\Mvc\View\View;
use Cygnite\Foundation\Application;
use Cygnite\Http\Responses\Response;
use Cygnite\Mvc\Controller\AbstractBaseController;
use Apps\Form\ProductForm;
use Apps\Models\Product;

/**
* This file is generated by Cygnite Crud Generator
* You may alter code to fit your need
*/

class ProductController extends AbstractBaseController
{
    /**
    * --------------------------------------------------------------------------
    * The Product Controller
    *--------------------------------------------------------------------------
    *  This controller respond to uri beginning with product and also
    *  respond to root url like "product/index"
    *
    * Your GET request of "product/index" will respond like below -
    *
    *     public function indexAction()
    *     {
    *            echo "Cygnite : Hello ! World ";
    *     }
    *
    */

    // Plain layout
    protected $layout = 'layouts.base';

    /**
    * Your constructor.
    * @access public
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Default method for your controller. Render index page into browser.
    * @access public
    * @return void
    */
    public function indexAction()
    {
        $product = [];
        $product = Product::all(['orderBy' => 'id desc',
                /*'paginate' => [
                    'limit' => Url::segment(3)
                )*/]
        );

        $content = View::create('Apps.Views.product.index', [
                'records' => $product,
                'links' => '', //Product::createLinks(),
                'title' => 'Cygnite Framework - Crud Application'
        ]);

        return Response::make($content);
    }

    /**
    * Set Validation rules for Form
    * @param $input
    * @return mixed
    */
    private function setValidationRules($input)
    {
        //Set Form validation rules
        return Validator::instance($input, function ($validate) {
            $validate->addRule('product_name', 'required|min:5')
                    ->addRule('category', 'required|min:5')
                    ->addRule('description', 'required|min:5')
                    ->addRule('validity', 'required|min:5')
                    ->addRule('price', 'required|min:5')
                    ->addRule('created_at', 'required|min:5')
                    ->addRule('updated_at', 'required|min:5');

            return $validate;
        });
    }

    /**
     * Add a new product
     * @return void
     */
    public function addAction()
    {
        $validator = null;
        $form = new ProductForm();
        $form->action = 'add';
        $input = Input::make();

        //Check is form posted
        if ($input->hasPost('btnSubmit') == true) {
            $validator = $this->setValidationRules($input);

            //Run validation
            if ($validator->run()) {
                $product = new Product();
                // get post array value except the submit button
                $postArray = $input->except('btnSubmit')->post();

                $product->product_name = $postArray["product_name"];
                $product->category = $postArray["category"];
                $product->description = $postArray["description"];
                $product->validity = $postArray["validity"];
                $product->price = $postArray["price"];
                $product->created_at = $postArray["created_at"];
                $product->updated_at = $postArray["updated_at"];

                // Save form details
                if ($product->save()) {
                    $this->setFlash('success', 'Product added successfully!')
                        ->redirectTo('product/index/'.Url::segment(3));
                } else {
                    $this->setFlash('error', 'Error occured while adding Product!')
                        ->redirectTo('product/index/'.Url::segment(3));
                }
            } else {
                //validation error here
                $form->errors = $validator->getErrors();
            }

            $form->validation = $validator;
        }

        // We can also use same view page for create and update
        $content = View::create('Apps.Views.product.create', [
                'form' => $form->render(),
                'validation_errors' => $form->errors,
                'title' => 'Add a new Product'
            ]);

        return Response::make($content);
    }

    /**
     * Update a product
     *
     * @param $id
     */
    public function editAction($id)
    {
        $validator = null;
        $product = [];
        $product = Product::find($id);
        $form = new ProductForm($product, Url::segment(3));
        $form->action = 'edit';

        $input = Input::make();

        //Check is form posted
        if ($input->hasPost('btnSubmit') == true) {
            $validator = $this->setValidationRules($input);

            //Run validation
            if ($validator->run()) {

                // get post array value except the submit button
                $postArray = $input->except('btnSubmit')->post();

                $product->product_name = $postArray["product_name"];
                $product->category = $postArray["category"];
                $product->description = $postArray["description"];
                $product->validity = $postArray["validity"];
                $product->price = $postArray["price"];
                $product->created_at = $postArray["created_at"];
                $product->updated_at = $postArray["updated_at"];

                // Save form information
                if ($product->save()) {
                    $this->setFlash('success', 'Product updated successfully!')
                        ->redirectTo('product/index/'.Url::segment(3));
                } else {
                    $this->setFlash('error', 'Error occured while updating Product!')
                        ->redirectTo('product/index/'.Url::segment(3));
                }
            } else {
                //validation error here
                $form->errors = $validator->getErrors();
            }

            $form->validation = $validator;
        }

        $content = View::create('Apps.Views.product.update', [
                'form' => $form->render(),
                'validation_errors' => $form->errors,
                'title' => 'Update The Product'
        ]);

        return Response::make($content);
    }

    /**
    *  Display product details
    * @param type $id
    */
    public function showAction($id)
    {
        $product = Product::find($id);

        $content = View::create('Apps.Views.product.show', [
                'record' => $product,
                'title' => 'Show the Product'
        ]);

        return Response::make($content);
    }

    /**
    * Delete product using id
    *
    * @param type $id
    */
    public function deleteAction($id)
    {
        $product = new Product();

        if ($product->trash($id) == true) {
            $this->setFlash('success', 'Product Deleted Successfully!')
                 ->redirectTo('product/');
        } else {
            $this->setFlash('error', 'Error Occured while deleting Product!')
                 ->redirectTo('product/');
        }
    }
}//End of your Product controller

