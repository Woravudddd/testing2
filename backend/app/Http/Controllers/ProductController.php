<?php

namespace App\Http\Controllers;

use App\Models\Bookstore;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bookstore::select('id','title',
        'author',
        'description',
        'price',
        'tags',)->get();
    }

  
 
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'description'=>'required',
            'price'=>'required',
            'tags'=>'required',
        ]);

        try{
            
            $tagsname = Str::lower(Str::random(4));
            Bookstore::create($request->post()+['tags'=>$tagsname]);

            return response()->json([
                'message'=>'Product Created Successfully!!'
            ]);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while creating a Book!!'
            ],500);
        }
    }

  
    public function show(Bookstore $bookstore)
    {
        return response()->json([
            'Bookstore'=>$bookstore
        ]);
    }


    public function update(Request $request, Bookstore $bookstore)
    {
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'description'=>'required',
            'price'=>'required',
            'tags'=>'required',
        ]);

        try{

            $bookstore->fill($request->post())->update();

            

         
          
                $tagsname  = Str::random($request->tags);
                $bookstore->tags = $tagsname;
                $bookstore->save();
            

            return response()->json([
                'message'=>'Product Updated Successfully!!'
            ]);

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while updating a product!!'
            ],500);
        }
    }
    public function destroy(Bookstore $bookstore)
    {
        try {
            
        
           
            
            $bookstore->delete();

            

            return response()->json([
                'message'=>'Book has been Deleted!!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while deleting a Book!!'
            ]);
        }
    }
}
