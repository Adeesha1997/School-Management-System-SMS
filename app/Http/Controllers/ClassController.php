<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function list()
    {
        $data['getRecord'] = ClassModel::getRecord();
        $data['header_title'] = "Class List";
        return view('admin.class.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New Class';
        return view('admin.class.add', $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'status' => 'required',


        ]);

        $class = new ClassModel;
        $class->name = trim($request->name);
        $class->status = $request->status;
        $class->created_by = Auth::user()->id;
        $class->save();

    return redirect('admin/class/list')->with('success', 'Class Created Successfully !');

    }


    public function edit($id)
    {

            $data['getRecord'] = ClassModel::getSingle($id);

            if(!empty($data['getRecord']))
            {
                $data['header_title'] = 'Edit Class';
                return view('admin.class.edit', $data);
            }
            else
            {
                abort(404);
            }

    }

    public function update($id, Request $request)
    {

        request()->validate([
            'name' => 'required',
            'status' => 'required',

        ]);

        $class =  ClassModel::getSingle($id);
        $class->name = trim($request->name);
        $class->status = $request->status;
        $class->save();

    return redirect('admin/class/list')->with('success', 'Class Updated Successfully !');

    }


    public function delete($id)
    {
        $class = ClassModel::getSingle($id);
        $class->is_delete = 1;
        $class->save();

        return redirect('admin/class/list')->with('success', 'Class Deleted Successfully !');
    }


}

