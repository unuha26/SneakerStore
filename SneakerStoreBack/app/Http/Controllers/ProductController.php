<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\ProductImage;

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
    function SaveProductImage(Request $req){
        DB::beginTransaction();
        try{
            $this->validate($req, [
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'product_id' =>'required'
            ]);

            $productId = $req->input('product_id');
            $image = $req->file('image');

            $file_name = time() . '.' . $image->getClientOriginalExtension();
            $file_path = '/img/product/' . $productId;
            $file_destination = public_path($file_path);

            $productImage = new ProductImage;
            $productImage->product_id = $productId;
            $productImage->image = $file_path . "." . $file_name;
            $productImage->default = false;
            $productImage->save();

            DB::commit();

            $image->move($file_destination, $file_name);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Failed to create user, exception:'+$e], 500);
        }
    }
    function ViewProduct(Request $req){
        DB::beginTransaction();
        try{
            $this->validate($req, [
                'product_id' => 'required'
            ]);
            $productId = $req->input('product_id');
            $product = DB::selectOne(DB::raw('select id, name, unit_price, 
                                      description from products 
                                      where id = ?'), [$productId]);
            if (empty($product)){
                return response()->json(['message' => 'product not found'], 400);
            }
            $productDetails = DB::select(DB::raw('select id product_details_id,
                                          size, stock from product_details 
                                          where product_id = :pId'), ['pId' => $productId]);
            $productImages = DB::select('select *
                                         from product_images 
                                         where product_id = ' . $productId . ' '
                                         );
            $product->product_details = $productDetails;
            $product->product_images = $productImages;
            DB::commit();
            return response()->json($product, 200);            
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'failed' +$e], 500);
        }
    }
}
