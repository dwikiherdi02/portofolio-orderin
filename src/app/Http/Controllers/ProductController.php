<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public const PAGE = 'Products';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('product.index');
    }

    public function list(Request $request): JsonResponse
    {
        $start = $request->get('start') * $request->get('length');

        $model = Product::select(['id', 'image', 'name', 'price', 'categories', DB::raw('@rownum := @rownum + 1 as rownum')])->crossJoin(DB::raw("(select @rownum := $start) r"));

        $dataTable = new DataTables();

        return $dataTable->eloquent($model)
            ->order(function ($query) use ($request) {
                $columns = array_column($request->get('columns'), 'data');
                $orders = $request->get('order');
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $column = $columns[$order['column']];
                        $sort = $order['dir'];
                        $query->orderBy($column, $sort);
                    }
                } else {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('id', '{{ $rownum }}')
            ->addColumn('image', function (Product $data) {
                return view('product.list.image', compact('data'))->render();
            })
            ->addColumn('name', '{{ $name }}')
            ->addColumn('price', function (Product $data) {
                return number_format($data->price, 2, ',', '.');
            })
            ->addColumn('categories', function (Product $data) {
                return implode(',', $data->categories);
            })
            ->addColumn('action', function (Product $data) {
                return view('product.list.action', compact('data'))->render();
            })
            ->rawColumns(['image', 'action'])
            ->toJson();
    }

    public function listOrdering(Request $request): JsonResponse
    {
        $start = $request->get('start') * $request->get('length');

        $model = Product::select(['id', 'name', 'price', DB::raw('@rownum := @rownum + 1 as rownum')])->crossJoin(DB::raw("(select @rownum := $start) r"));

        $dataTable = new DataTables();

        return $dataTable->eloquent($model)
            ->order(function ($query) use ($request) {
                $columns = array_column($request->get('columns'), 'data');
                $orders = $request->get('order');
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $column = $columns[$order['column']];
                        $sort = $order['dir'];
                        $query->orderBy($column, $sort);
                    }
                } else {
                    $query->orderBy('name', 'asc');
                }
            })
            ->addColumn('id', '{{ $rownum }}')
            ->addColumn('name', '{{ $name }}')
            ->addColumn('price', function (Product $data) {
                return number_format($data->price, 2, ',', '.');
            })
            ->addColumn('action', function (Product $data) {
                return view('product.list.add-product', compact('data'))->render();
            })
            ->addColumn('data', function (Product $data) {
                return $data;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::select('name')->orderBy('name', 'asc')->get();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse|JsonResponse
    {
        if ($request->ajax()) {
            if ($errMsg = $request->isValid()) {
                return response()->json(
                    [
                        'code' => 422,
                        'msg-key' => 'ERROR-VALIDATION',
                        'message' => 'validation error.',
                        'data' => $errMsg
                    ],
                    422
                );
            }

            $request->session()->flash('isValid', true);

            return response()->json([
                'code' => 200,
                'msg-key' => 'SUCCESS',
                'message' => 'success.'
            ]);
        }

        if (!$request->session()->has('isValid')) {
            abort(406);
        }

        DB::beginTransaction();
        try {
            $model = new Product();

            $model->fill($request->post());

            $model->save();

            if (!empty($request->file('image'))) {
                $file = $request->file('image');
                $filename = $file->hashName();
                $path = "products";
                if (!empty($file->storeAs($path, $filename))) {
                    $model->fill(['image' => "{$path}/{$filename}"]);
                    $model->save();
                }
            }

            if (!empty($request->post('categories'))) {
                $categories = $request->post('categories');
                foreach ($categories as $category) {
                    Category::firstOrCreate(['name' => strtolower($category)]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('product.index')->with('notif-error', 'An Error Occurred While Saving Data.');
        }

        return redirect()->route('product.index')->with('notif-success', 'Data Save Successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::select('name')->orderBy('name', 'asc')->get();
        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        if ($request->ajax()) {
            if ($errMsg = $request->isValid()) {
                return response()->json(
                    [
                        'code' => 422,
                        'msg-key' => 'ERROR-VALIDATION',
                        'message' => 'validation error.',
                        'data' => $errMsg
                    ],
                    422
                );
            }

            $request->session()->flash('isValid', true);

            return response()->json([
                'code' => 200,
                'msg-key' => 'SUCCESS',
                'message' => 'success.'
            ]);
        }

        if (!$request->session()->has('isValid')) {
            abort(406);
        }

        DB::beginTransaction();
        try {
            $product->fill($request->post());

            $product->save();

            if ($request->post('isrm_image') && !empty($product->image)) {
                Storage::delete($product->image);
                $product->fill(['image' => ''])->save();
            }

            if (!empty($request->file('image'))) {
                $file = $request->file('image');
                $filename = $file->hashName();
                $path = "products";
                if (!empty($file->storeAs($path, $filename))) {
                    $product->fill(['image' => "{$path}/{$filename}"]);
                    $product->save();
                }
            }

            if (!empty($request->post('categories'))) {
                $categories = $request->post('categories');
                foreach ($categories as $category) {
                    Category::firstOrCreate(['name' => strtolower($category)]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('product.index')->with('notif-error', 'An Error Occurred While Saving Data.');
        }

        return redirect()->route('product.index')->with('notif-success', 'Data Save Successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        if (empty($product)) {
            return response()->json([
                'code' => 404,
                'msg-key' => 'NOT-FOUND',
                'message' => ''
            ], 404);
        }

        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();

            return response()->json([
                'code' => 400,
                'msg-key' => 'BAD-REQUEST',
                'message' => ''
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'msg-key' => 'SUCCESS',
            'message' => 'success.'
        ]);
    }

    public function ajaxList(Request $request): JsonResponse
    {
        $model = Product::select(['id', 'name', 'price', 'description', 'image']);

        if ($request->has('search') && !empty($request->get('search'))) {
            $search = $request->get('search');
            $model = $model->where(function ($query) use ($search) {
                $query->whereLike('name', "%$search%")
                    ->orWhereLike('description', "%$search%");
            });

        }

        $products = $model->get();


        $data = [];
        foreach ($products as $product) {
            $data[$product->id] = view('product.card-list', compact('product'))->render();
        }

        return response()->json([
            'code' => 200,
            'msg-key' => 'SUCCESS',
            'message' => 'success.',
            'results' => $data,
        ]);
    }
}
