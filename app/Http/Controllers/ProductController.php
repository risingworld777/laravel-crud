<?php
  
namespace App\Http\Controllers;
  
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
  
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $data = $products->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Products retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $product = Product::create($input);
        $data = $product->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product stored successfully.'
        ];

        return response()->json($response, 200);
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Product not found.'
            ];
            return response()->json($response, 404);
        }

        $data = $product->toArray();
        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Product not found.'
            ];
            return response()->json($response, 404);
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();

        $data = $product->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product updated successfully.'
        ];

        return response()->json($response, 200);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $data = $product->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}