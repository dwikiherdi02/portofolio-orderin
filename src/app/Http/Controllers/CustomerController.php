<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public const PAGE = 'Customers';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('customer.index');
    }

    public function list(Request $request): JsonResponse
    {
        $start = $request->get('start') * $request->get('length');

        $model = Customer::select(['id', 'name', DB::raw('@rownum := @rownum + 1 as rownum')])
            ->crossJoin(DB::raw("(select @rownum := $start) r"));

        $dataTable = new DataTables();

        return $dataTable->eloquent($model)
            // ->filter(function ($query) use ($request) {
            //     if (!empty($request->get('search'))) {
            //         $search = $request->get('search');
            //         $query->where(function ($query) use ($search) {
            //             $query->where(DB::raw('lower(name)'), 'like', '%' . $search . '%')
            //                 ->orWhere(DB::raw('lower(address)'), 'like', '%' . $search . '%');
            //         });
            //     }
            // })
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
            ->addColumn('name', '{{ $name }}')
            ->addColumn('action', function (Customer $data) {
                return view('customer.list.action', compact('data'))->render();
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request): RedirectResponse|JsonResponse
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
            $model = new Customer();

            $model->fill($request->all());

            $model->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.index')->with('notif-error', 'An Error Occurred While Saving Data.');
        }

        return redirect()->route('customer.index')->with('notif-success', 'Data Save Successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
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
            $customer->fill($request->all());

            $customer->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.index')->with('notif-error', 'An Error Occurred While Saving Data.');
        }

        return redirect()->route('customer.index')->with('notif-success', 'Data Save Successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        if (empty($customer)) {
            return response()->json([
                'code' => 404,
                'msg-key' => 'NOT-FOUND',
                'message' => ''
            ], 404);
        }

        DB::beginTransaction();
        try {
            $customer->delete();
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
}
