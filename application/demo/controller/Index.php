<?php
namespace app\demo\controller;

class Index
{
    public function index()
    {
    	return 'demo';
    }

    public function HelloWorld($name='panbin')
    {
    	return 'hello '.$name.'!';
    }
    public function hello($name='panbin', $city='beijing')
    {
    	return 'hello '.$name.'!  '.' you are from '.$city.' ?';
    }
}
