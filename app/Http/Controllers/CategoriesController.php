<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Categories;
use DB;
use Auth;

class CategoriesController extends Controller
{
    public function index()
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
        $ldms_role_data = Role::where('id', $ldms_user_data->role_id)->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($ldms_role_data->title == 'admin') {
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where([
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                        ])->get();

            $categories = Categories::all();
            return view('categories.index', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'categories'));
        }
    }

    public function store(Request $request)
    {
        $add = new Categories();

        $add->name = htmlspecialchars($request->name);
        $add->parent = $request->parent;
        $add->save();

        return redirect()->back()->with('message', 'Category added');
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request)
    {
        $update = Categories::find($request->id);

        $update->name = htmlspecialchars($request->name);
        $update->parent = $request->parent;
        $update->save();

        return redirect()->back()->with('message', 'Category updated');
    }

    public function delete(Request $request)
    {
        $categories = Categories::find($request->category_id);
        $categories->delete();

        return redirect()->back()->with('message', 'Category deleted');
    }
}
