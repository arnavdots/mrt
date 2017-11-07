<?php

namespace Modules\StockControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPriceTier;
use Modules\Product\Entities\ProductPrices;
use Modules\Product\Entities\ProductDimensions;
use Modules\Product\Entities\ProductBom;
use Modules\Product\Entities\Currency;
use Modules\Financial\Entities\Supplier;
use Modules\StockControl\Http\Requests\NewRequest;
use Illuminate\Support\Facades\Auth;

class StockControlNewProductController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {

        $url = 'new_product.store';
        $newproduct = new Product;
        $tiers = ProductPriceTier::get();
        $currency = Currency::get();
        $suppliers = Supplier::pluck('name', 'id')->prepend('Select Supplier', '');

        return view('stockcontrol::newproduct.index', compact('url', 'newproduct', 'tiers', 'currency', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $url = 'new_product.store';
        $newproduct = new Product;
        return view('stockcontrol::newproduct.create', compact('newproduct', 'url'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(NewRequest $request) {

      
        try {
            $newProduct = new Product;
            $newProduct->product_code = $request->product_code;
            $newProduct->slug = Product::createSlug($request->product_code);
            $newProduct->invoice_description = $request->invoice_description;
            $newProduct->specifications = $request->specifications;
            $newProduct->weight = $request->weight;
            $newProduct->is_gst = (!empty($request->is_gst)) ? true : false;
            $newProduct->custom_price = $request->custom_price;
            $newProduct->is_completed = ($request->is_completed == 1) ? true : false;
            $newProduct->is_bom = ($request->is_bom == 1) ? true : false;
            $newProduct->is_active = (!empty($request->is_active)) ? true : false;
            $newProduct->creator_id = Auth::guard('admin')->user()->id;
            $newProduct->modifier_id = Auth::guard('admin')->user()->id;
            $newProduct->supplier_id = $request->supplier_id;
            $newProduct->currency_id = $request->currency_id;
            $newProduct->cost_price = $request->cost_price;
            $newProduct->ideal_qty = $request->ideal_qty;
            $newProduct->alert_level_low_stock = $request->alert_level_low_stock;
            $newProduct->alert_level_week_sales = $request->alert_level_week_sales;

            if ($newProduct->save()) {
                $bomProduct = [];
                if(!empty($request->bom_product_id)){
                    $p_ID = Product::getAllProductIds($request->bom_product_id);
                    foreach ($p_ID as $key => $value) {
                         $bomProduct[] = new ProductBom([
                            'bom_product_id' => $value['id'],
                        ]);
                    }
                    $newProduct->productbom()->saveMany($bomProduct);
                }
                // saving information into product price table
                $productprice = [];
                foreach ($request->price as $key => $value) {
                    $productprice[] = [
                        'price' => $value,
                        'product_price_tier_id' => $request->product_price_tier_id[$key],
                    ];
                }
                $newProduct->productprice()->sync($productprice);

                // saving information into product-dimissions table
                $productdimensions = [];
                foreach ($request->dimission as $key => $value) {

                    $productdimensions[] = new ProductDimensions([
                        'length' => $value['length'],
                        'width' => $value['width'],
                        'height' => $value['height'],
                        'dimension_type' => $key,
                    ]);
                }
                $newProduct->productdimensions()->saveMany($productdimensions);

                return array(
                    'status' => 'success',
                    'message' => __('stockcontrol::stockcontrol.newproduct_added'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('stockcontrol::stockcontrol.newproduct_not_added'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show() {
        return view('stockcontrol::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit() {
        return view('stockcontrol::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {
        
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy() {
        
    }
    
     /**
     * get specific data after search product code 
     * @return json
     */
    public function productSearch(Request $request) {
        if ($request->has('query')) {
            $q = $request->input('query');
            $products = Product::where('product_code', 'like', '%' . $q . '%')->get()->toArray();
            if ($products) {
                foreach ($products as $key => $value) {
                   
                    $result[] = $value["product_code"];
                }
                echo json_encode($result);
            }
        }
    }

}
