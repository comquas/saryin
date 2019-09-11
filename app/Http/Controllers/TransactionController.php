<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;
class TransactionController extends Controller
{

    private function validation() {
        return [
            'name' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date_format:d/m/Y',
            'categoryID' => 'nullable|integer',
            'customerID' => 'nullable|integer',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,zip'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Transactions';
        $pageno = $request->page;
        
        if($pageno == null) {
            $pageno = 1;
        }

        
        $orderBy = $request->orderBy;
        $orderType = $request->orderType;

        if($orderBy == null) {
            $orderBy = "date";
            $orderType = "desc";
        }
        else if($orderBy == 1) {
            $orderBy = "date";
        }
        else if($orderBy == 2) {
            $orderBy = "id";
        }

        if($orderType == 1 ) {
            $orderType = "asc";
        }
        else {
            $orderType = "desc";
        }

        $transactions = Transaction::query();

        $dates = $request->dates;
        if($dates != null) {
            $d = explode("-",$dates);
            
            $start = Carbon::createFromFormat("d/m/Y",trim($d[0]));
            $end = Carbon::createFromFormat("d/m/Y",trim($d[1]));

            $transactions->where('date','>=',$start)->where('date','<=',$end);
        }

        $type = $request->type;

        if($type != null) {
            if($type == 4) {
                $transactions->where("type",2)->where("type",3);
            }
            else {
                $transactions->where("type",$type);
            }
        }
        else {
            $type == "";
        }

        if($request->query !=null && trim($request->query) != "") {
            $transactions->where("name","like","%{$request->query}%");
        }

        $transactions = $transactions->orderBy($orderBy,$orderType);

        $inAmount = (clone $transactions)->where("type",1)->sum("amount");
        $outAmount = (clone $transactions)->where("type","!=",1)->sum("amount");
        $diffAmount = $inAmount - $outAmount;

        
        
        $transactions = $transactions->paginate(50);
        return view('admin.transactions.list',compact('title','transactions',
        'pageno','orderBy','orderType','dates','type','inAmount','outAmount','diffAmount'));
    }


    private function formData($edit,$transaction,$type) {

        $formData = [
            [
                "label" => "Name",
                "name" => "name",
                "edit" => $edit,
                "value" => isset($transaction->name) ? $transaction->name : old("name","")
            ],
            [
                "label" => "Date",
                "name" => "date",
                "edit" => $edit,
                "value" => isset($transaction->date) ? Carbon::parse($transaction->date)->format("d/m/Y") : old("date",""),
                "date" => true
            ],
            [
                "label" => "Currency",
                "name" => "currency",
                "edit" => $edit,
                "value" => isset($transaction->currency) ? $transaction->currency : old("currency","MMK"),
            ],
            [
                "label" => "Amount",
                "name" => "amount",
                "edit" => $edit,
                "value" => isset($transaction->amount) ? $transaction->amount : old("amount","")
            ],
            [
                "label" => "Description",
                "name" => "description",
                "edit" => $edit,
                "value" => isset($transaction->description) ? $transaction->description : old("description","")
            ],
            
            [
                "label" => "Attachment",
                "name" => "attachment",
                "edit" => $edit,
                "value" => isset($transaction->attachment) ? Storage::url($transaction->attachment) : "",
                "file" => true
            ],
            [
                "label" => "Category",
                "name" => "categoryID",
                "edit" => $edit,
                "value" => isset($transaction->categoryID) ? $transaction->categoryID : "",
                "route" => route('category.search',["type"=>$type]),
                "selectLabel" => isset($transaction->categoryID) ? $transaction->category->name : ""
            ],
            [
                "label" => "Customer",
                "name" => "customerID",
                "edit" => $edit,
                "value" => isset($transaction->customerID) ? $transaction->customerID : "",
                "route" => route('customer.search'),
                "selectLabel" => isset($transaction->customerID) && $transaction->customerID != "" ? $transaction->customer->name : ""
            ],
           

        ];
        return $formData;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type= $request->type;
        if($type == null) {
            abort(401);
        }

        $title = "Create Transaction";
        $edit = false;

        
        $formData = $this->formData(false,null,$type);

        return view('admin.transactions.add',compact('title','edit','formData','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation());

        $data = $request->all();
        
        $data["date"] = Carbon::createFromFormat("d/m/Y",$data["date"]);
        
        if(isset($request->attachment)) {
            $path = $request->file('attachment')->store('transactions');
            $data["attachment"] = $path;
        }
        
        if(Auth::user()->role == 1) {
            
            Transaction::create($data);
        }

        return redirect()->route('transactions.index');

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
        $title = "Edit Transaction";
        $edit = true;
        
        $transaction = Transaction::where("id",$id)->first();
        if($transaction==null) {
            abort(404);
        }
        $type= $transaction->type;
        $id = $transaction->id;
        $formData = $this->formData($edit,$transaction,$type);


        return view('admin.transactions.add',compact('id','title','edit','formData','type'));
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
        $request->validate($this->validation());

        $transaction = Transaction::where('id',$id)->first();
        if($transaction == null) {
            return abort(404);
        }

        $data = $request->all();
        $data["date"] = Carbon::createFromFormat("d/m/Y",$data["date"]);
        if(isset($request->attachment)) {
            if($request->file('attachment')->isValid()) {
                //delete old file
                Storage::delete($transaction->attachment);
                $path = $request->file('attachment')->store('transactions');
                $data["attachment"] = $path;

            }
            else {
                abort(401,$request->file('attachment')->getErrorMessage());
            }
            
        }

        $transaction->fill($data)->save();
        
        return redirect()->route('transactions.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::where('id',$id)->first();
        if($transaction->attachment !=null && $transaction->attachment != "") {
            Storage::delete($transaction->attachment);
        }
        
        $transaction->delete();
        return redirect()->route('transactions.index');
    }

   
}
