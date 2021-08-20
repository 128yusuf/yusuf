<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Product;
use App\Traits\CustomTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use CustomTraits;
    protected $path = '';

    public function __construct() {
        $this->path = public_path(config('constant.file_path.product'));
    }

    public function index() {

        return view('shop.product.index');
    }

    public function ajax() {
        $categories = config('constant.category');
        $subCategories = config('constant.sub_category');
        $data = Product::query();
        return DataTables::of($data)
            ->editColumn('product_name',function($row){
                return $row->product_name;
            })
            ->editColumn('image',function($row){
                return '<img alt="Image placeholder" width="100" height="100" src="'.url(config('constant.file_path.product')."/$row->image") .'">';
            })->editColumn('category',function($row) use($categories){
                return $categories[$row->category];
            })->editColumn('sub_category',function($row) use($subCategories){
                return $subCategories[$row->category][$row->sub_category];
            })->addColumn('action', function($row){
                $btn = '<a href="'.route('product.edit',['id' => $row->id]).'" class="edit btn btn-primary btn-sm">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })->rawColumns(['action','image'])->make(true);
    }

    public function add() {
        return view('shop.product.add');
    }

    public function store(Request $request) {


        $this->validateData();

        $product = new Product($request->only('price','category','sub_category'));
        $product->setTranslationsFields();
        $this->createDirectory($this->path);

        $product->image = $this->saveCustomFileAndGetImageName(request()->file('image'),$this->path);;
        $product->status = $request->status == 'on' ? true : false;

        $product->save();
        return redirect(route('products'))->with('status','Product Created Successfully');
    }

    public function edit($id) {

        $product = Product::findOrFail($id);
        $translation = $product->getTranslations();

        return view('shop.product.edit', [
            'data' => Product::findOrFail($id),
            'translation' => $translation
        ]);
    }

    public function update(Request $request, $id) {

        $this->validateData();

        $product = Product::findOrFail($id);

        if($request->hasFile('image')) {
            $this->removeOldImage($product->image,$this->path);
            $product->image = $this->saveCustomFileAndGetImageName(request()->file('image'),$this->path);
        }
        $product->setTranslationsFields();
        $product->status = $request->status == 'on' ? true : false;
        $product->fill($request->only('product_name','description','price','category','sub_category'))->save();
        return redirect(route('products'))->with('status','Product Updated Successfully');
    }

    protected function validateData () {

        $imageRules = ['mimes:jpeg,jpg,png'];
        if(Route::currentRouteName() == 'product.store')
                array_push($imageRules,'required');

        $fieldsArray = [
            'product_name' => 'required|max:200',
            'product_name_nl' => 'required|max:200',
            'price' => 'required|numeric|between:0,100000',
            'category' => ['required'],
            'sub_category' => ['required'],
            'image' => $imageRules
        ];


        $this->validate(request(),$fieldsArray);
    }

    public function delete(Request $request) {

        if(!$product = Product::whereId($request->id)->first())
            return response()->json(['code' => 200,'msg' => 'Product Deleted Successfully']);

        $this->removeOldImage($product->image,$this->path);
        $product->delete();
        return response()->json(['code' => 200,'msg' => 'Product Deleted Successfully'],200);
    }
}
