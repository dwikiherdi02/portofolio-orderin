<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public const PAGE = 'Order';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('order.index');
    }

    public function list(Request $request): JsonResponse
    {
        $start = $request->get('start') * $request->get('length');

        $model = Order::select(['id', 'order_no', 'ordered_at', 'created_at', 'customer_id', 'total_items', 'total_price', DB::raw('@rownum := @rownum + 1 as rownum')])->crossJoin(DB::raw("(select @rownum := $start) r"));

        $dataTable = new DataTables();

        return $dataTable->eloquent($model)
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $query->where(function ($query) use ($search) {
                        $query->where(DB::raw('lower(order_no)'), 'like', '%' . $search . '%')
                            ->orWhere(DB::raw('total_items'), 'like', '%' . $search . '%')
                            ->orWhere(DB::raw('total_price'), 'like', '%' . $search . '%')
                            ->orWhereHas('customer', function (Builder $query) use ($search) {
                                $query->whereLike(DB::raw('lower(name)'), '%' . $search . '%');
                            });
                    });
                }

                if (!empty($request->get('ordered_at_from'))) {
                    $orderedAtFrom = $request->get('ordered_at_from');
                    $query->where('ordered_at', '>=', Carbon::parse($orderedAtFrom)->format('Y-m-d'));
                }

                if (!empty($request->get('ordered_at_to'))) {
                    $orderedAtTo = $request->get('ordered_at_to');
                    $query->where('ordered_at', '<=', Carbon::parse($orderedAtTo)->format('Y-m-d'));
                }

                if (!empty($request->get('created_at_from'))) {
                    $createdAtFrom = $request->get('created_at_from');
                    $query->where('created_at', '>=', Carbon::parse($createdAtFrom)->format('Y-m-d H:i:00'));
                }

                if (!empty($request->get('created_at_to'))) {
                    $createdAtTo = $request->get('created_at_to');
                    $query->where('created_at', '<=', Carbon::parse($createdAtTo)->format('Y-m-d H:i:59'));
                }

            })
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
                    $query->orderBy('created_at', 'desc');
                }
            })
            ->addColumn('id', '{{ $rownum }}')
            ->addColumn('customer', function (Order $data) {
                return $data->customer->name;
            })
            ->addColumn('order_no', '{{ $order_no }}')
            ->addColumn('ordered_at', '{{ $ordered_at }}')
            ->addColumn('created_at', '{{ $created_at }}')
            ->addColumn('total_items', '{{ $total_items }}')
            ->addColumn('total_price', function (Order $data) {
                return number_format($data->total_price, 2, ',', '.');
            })
            ->addColumn('action', function (Order $data) {
                return view('order.list.action', compact('data'))->render();
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::select(['id', 'name'])->orderBy('name', 'asc')->get();
        return view('order.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request): RedirectResponse|JsonResponse
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

        $totalItems = collect($request->post('detail'))->reduce(function (int|null $carry, array $item) {
            return $carry + $item['qty'];
        });

        $totalPrice = collect($request->post('detail'))->reduce(function (int|null $carry, array $item, string $productID) {
            $product = Product::find($productID, ['price']);
            $price = $product->price ?? 0;
            return $carry + ($item['qty'] * $price);
        });

        $orderData = [
            'ordered_at' => $request->post('ordered_at'),
            'customer_id' => $request->post('customer_id'),
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
        ];

        DB::beginTransaction();
        try {
            $order = new Order();

            $order->fill($orderData);

            $order->save();

            foreach ($request->post('detail') as $productID => $item) {
                $product = Product::find($productID);
                $price = $product->price ?? 0;

                $orderDetail = new OrderDetail();
                $orderDetail->fill([
                    'order_id' => $order->id,
                    'product_id' => $productID,
                    'qty' => $item['qty'],
                    'price' => $price,
                    'total_price' => $price * $item['qty'],
                ])->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->route('order.index')->with('notif-error', 'An Error Occurred While Saving Data.');
        }

        return redirect()->route('order.index')->with('notif-success', 'Data Save Successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        return view('order.show', compact('order'));
    }
}
