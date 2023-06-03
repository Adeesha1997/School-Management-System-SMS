<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Auth;

class SubjectController extends Controller
{
    public function list()
    {
        $data['getRecord'] = Subject::getRecord();
        $data['header_title'] = "Class List";
        return view('admin.subject.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New CSubjectlass';
        return view('admin.subject.add', $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'status' => 'required',
            'type' => 'required',


        ]);

        $subject = new Subject;
        $subject->name = trim($request->name);
        $subject->status = $request->status;
        $subject->type = $request->type;
        $subject->created_by = Auth::user()->id;
        $subject->save();

    return redirect('admin/subject/list')->with('success', 'Subject Created Successfully !');

    }

    public function edit($id)
    {

            $data['getRecord'] = Subject::getSingle($id);

            if(!empty($data['getRecord']))
            {
                $data['header_title'] = 'Edit Subject';
                return view('admin.subject.edit', $data);
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
            'type' => 'required',

        ]);

        $subject =  Subject::getSingle($id);
        $subject->name = trim($request->name);
        $subject->status = $request->status;
        $subject->type = $request->type;
        $subject->save();

    return redirect('admin/subject/list')->with('success', 'Subject Updated Successfully !');

    }


    public function delete($id)
    {
        $subject = Subject::getSingle($id);
        $subject->is_delete = 1;
        $subject->save();

        return redirect('admin/subject/list')->with('success', 'Subject Deleted Successfully !');
    }

}
