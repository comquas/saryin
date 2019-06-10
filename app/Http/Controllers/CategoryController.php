<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Categories';
        $pageno = $request->page;
        if($pageno == null) {
            $pageno = 1;
        }
        $categories = Category::orderBy('name')->paginate(20);
        return view('admin.category.list',compact('title','categories','pageno'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Category';
        $edit = false;
        return view('admin.category.add',compact('title','edit'));
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
            'name' => 'required',
            'type' => 'required',
        ]);

        if(Auth::user()->role == 1) {
            $data['name'] = $request->name;
            $data['type'] = $request->type;
            Category::create($data);
        }

        return redirect()->route('categories.index');
        
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

        $category = Category::where('id',$id)->first();
        if ($category == null) {
            return abort(404);
        }
        $title = 'Edit Category';
        $edit = true;
        return view('admin.category.add',compact('title','category','edit'));
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
        $category = Category::where('id',$id)->first();
        if($category == null) {
            return abort(404);
        }
        $category->name = $request->name;
        $category->type = $request->type;
        $category->update();
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id',$id)->delete();
        return redirect()->route('categories.index');
        
    }

    public function search($type,Request $request) {
        
        if($request->q != "" && strlen($request->q) > 3) {
            $results = Category::select('id','name as text')->where("name","like","%".$request->q . "%")->where("type",(int)$type)->limit(10)->get();
            return response()->json($results->toArray());
        }
        else {
            return response()->json(array());
        }
        
        
    }
}
