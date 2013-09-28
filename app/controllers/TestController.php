<?php

class TestController extends BaseController
{
    public function test()
    {
        echo $expenses = Prediction::find('9')->expenses()->sum('value');
        
    }
}