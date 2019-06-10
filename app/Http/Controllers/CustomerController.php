<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Auth;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Customers';
        $pageno = $request->page;
        if($pageno == null) {
            $pageno = 1;
        }
        $customers = Customer::orderBy('name')->paginate(20);
        return view('admin.customer.list',compact('title','customers','pageno'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Customer';
        $edit = false;
        $formData = [
            [
                "label" => "Name",
                "name" => "name",
                "edit" => $edit,
                "value" => ""
            ],
            [
                "label" => "Email",
                "name" => "email",
                "edit" => $edit,
                "value" => ""
            ],
            [
                "label" => "Company",
                "name" => "company",
                "edit" => $edit,
                "value" => ""
            ],
            [
                "label" => "Address",
                "name" => "address",
                "edit" => $edit,
                "value" => ""
            ],
            [
                "label" => "Address 2",
                "name" => "address2",
                "edit" => $edit,
                "value" => ""
            ],
            [
                "label" => "City",
                "name" => "city",
                "edit" => $edit,
                "value" => ""
            ],
            [
                "label" => "Country",
                "name" => "country",
                "edit" => $edit,
                "value" => ""
            ]

        ];
        
        return view('admin.customer.add',compact('title','edit','formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if(Auth::user()->role == 1) {
            
            Customer::create($request->all());
        }

        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Customer';
        $customer = Customer::where('id',$id)->first();
        if($customer == null) {
            return abort(404);
        }
        $edit = true;
        $formData = [
            [
                "label" => "Name",
                "name" => "name",
                "edit" => $edit,
                "value" => $customer->name
            ],
            [
                "label" => "Email",
                "name" => "email",
                "edit" => $edit,
                "value" => $customer->email
            ],
            [
                "label" => "Company",
                "name" => "company",
                "edit" => $edit,
                "value" => $customer->company
            ],
            [
                "label" => "Address",
                "name" => "address",
                "edit" => $edit,
                "value" => $customer->address
            ],
            [
                "label" => "Address 2",
                "name" => "address2",
                "edit" => $edit,
                "value" => $customer->address2
            ],
            [
                "label" => "City",
                "name" => "city",
                "edit" => $edit,
                "value" => $customer->city
            ],
            [
                "label" => "Country",
                "name" => "country",
                "edit" => $edit,
                "value" => $customer->country
            ]

        ];
        
        return view('admin.customer.add',compact('title','id','edit','formData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $customer = Customer::where('id',$id)->first();
        if($customer == null) {
            return abort(404);
        }
        $customer->fill($request->all())->save();
        
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::where('id',$id)->delete();
        return redirect()->route('customers.index');
    }

    public function search(Request $request) {
        if($request->q != "" && strlen($request->q) > 3) {
            $results = Customer::select('id','name as text')->where("name","like",$request->q . "%")->limit(10)->get();
            return response()->json($results->toArray());
        }
        else {
            return response()->json(array());
        }
    }
}
