<?php namespace Test\Projection;

use RedBeanPHP\R;
/**
 * Test Class to validate whether RedBEanPHP is a viable solution for turning our
 * RootEntities into a series of tables that can be queried.
 */
class RedBeanPHPTest extends \Test\DBTestCase
{
    public function setUp()
    {
        R::setup("sqlite::memory:");
    }
    
    public function test_creates_objects_from_data_structure()
    {
        $tree = (object)[
            'shopper_id' => '98590fc0-0076-4bd9-9d92-652de11d4d85',
            'address' => (object)[
                'line1' => 'value',
                'line2' => 'value'
            ],
            'product' => [
                (object)[
                    'uuid'=>'8793450b-ba0e-497a-9183-8a628438c6db',
                    'quantity'=>2
                ],
                (object)[
                    'uuid'=>'883bcf28-dbc1-44cd-b5c3-74d490167ca8',
                    'quantity'=>1
                ]
            ]
        ];
              
        $this->store_cart($tree);
        
        $products = R::getAll('SELECT * FROM product');
         
        $this->assertEquals(2, count($products));
        $this->assert_same_product($tree->product[0], (object)$products[0]);
        $this->assert_same_product($tree->product[1], (object)$products[1]);          
    }
    
    private function assert_same_product($expected, $actual)
    {
        $this->assertEquals($expected->quantity, $actual->quantity);
    }
    
    private function store_cart($data_tree) 
    {
        $cart = $this->make_object('carts', $data_tree);    
        
        R::store($cart);
    }
    
    private function make_object($name, $values)
    {
        $object = R::dispense($name);
        
        foreach ($values as $key=>$value) {
            if (is_array($value)) {
                $bean_key = "own".ucfirst($key)."List";
                foreach ($value as $child_value) {
                    $object->$bean_key[] = $this->make_object($key, $child_value);
                }
                
            } else if (is_object($value)) {
                $bean_key = "own".ucfirst($key)."List";
                $object->$key = $this->make_object($key, $value);
            } else {
                $object->$key = $value;
            }
        }
        
        return $object;
    }
}

