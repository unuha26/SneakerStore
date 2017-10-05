<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function GetAllProduct(){
        $productList = DB::select(
            'select p.id, p.name, p.unit_price, pi.image
             from products p
             join product_images pi on p.id = pi.product_id
             where pi.default = 1
             ');
        return response()->json($productList, 200);      
    }

    function AddProduct(){
    }

    function DeleteProduct(){

    }
    
    function UpdateProduct(){
        
    }
}
