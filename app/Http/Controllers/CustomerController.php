<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\DataTables\CustomerDataTable;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreCustomerRequest;

class CustomerController extends Controller {
    public function index() {
        return view('customer');
    }

    public function getCustomers() {
        $data = Customer::latest()->get();
        return DataTables::of($data)
            ->addColumn('Actions', function ($data) {
                return '<button type="button" class="btn btn-success btn-sm" data-target="#editCustomerModal" data-toggle="modal" id="getEditCustomerData" data-id="' . $data->id . '">Edit</button>
                    <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteCustomerModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    public function store(StoreCustomerRequest $request) {
        $request->validated();

        Customer::create($request->all());
        return 1;
    }

    public function edit($id) {
        return Customer::find($id);
    }

    public function update(StoreCustomerRequest $request, $id) {
        $request->validated();

        $student = Customer::find($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->save();
        return 'ok';
    }

    public function destroy($id) {
        Customer::find($id)->delete();
        return 'ok';
    }
}
