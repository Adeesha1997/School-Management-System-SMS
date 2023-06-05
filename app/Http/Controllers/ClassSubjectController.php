<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Class_Subject;
use App\Models\ClassModel;
use App\Models\Subject;
use Auth;

class ClassSubjectController extends Controller
{
    public function list()
    {
        $data['getRecord'] = Class_Subject::getRecord();
        $data['header_title'] = "Assign Subject";
        return view('admin.assign_subject.list', $data);
    }

    public function add()
    {

        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = Subject::getSubject();
        $data['header_title'] = 'Add New Assign Subject';
        return view('admin.assign_subject.add', $data);
    }

    public function insert(Request $request)
    {

        if(!empty($request->subject_id))
        {
            foreach($request->subject_id as $subject_id)
            {
                $getAlreadyFirst = Class_Subject :: getAlreadyFirst($request->class_id, $subject_id);
                if(!empty($getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
                else
                {
                    $subject = new Class_Subject;
                    $subject->class_id = $request->class_id;
                    $subject->subject_id = $subject_id;
                    $subject->status = $request->status;
                    $subject->created_by = Auth::user()->id;
                    $subject->save();

                }


            }
            return redirect('admin/assign_subject/list')->with('success', 'Subject Assign Successfully!');
        }
        else
        {
            return redirect()->back()->with('error', 'Due To Some Error Please Try Again !');
        }

    }


    public function edit($id)
    {

        $getRecord = Class_Subject::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = Class_Subject::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = Subject::getSubject();

            $data['header_title'] = 'Edit Assign Subject';
            return view('admin.assign_subject.edit', $data);

        }
        else
        {
            abort(404);
        }

    }

    public function update(Request $request)
    {

        if(!empty($request->subject_id))
        {
            foreach($request->subject_id as $subject_id)
            {
                $getAlreadyFirst = Class_Subject :: getAlreadyFirst($request->class_id, $subject_id);
                if(!empty($getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
                else
                {
                    $subject = new Class_Subject;
                    $subject->class_id = $request->class_id;
                    $subject->subject_id = $subject_id;
                    $subject->status = $request->status;
                    $subject->created_by = Auth::user()->id;
                    $subject->save();
                }


            }

        }
        return redirect('admin/assign_subject/list')->with('success', 'Subject Assign Updated Successfully!');

    }


    public function delete($id)
    {
        $classsubject = Class_Subject::getSingle($id);
        $classsubject->is_delete = 1;
        $classsubject->save();

        return redirect('admin/assign_subject/list')->with('success', 'Asssign Subject Deleted Successfully !');
    }

    public function edit_single($id)
    {
        $getRecord = Class_Subject::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = Subject::getSubject();

            $data['header_title'] = 'Edit Assign Subject';
            return view('admin.assign_subject.edit_single', $data);

        }
        else
        {
            abort(404);
        }

    }


    public function update_single($id, Request $request)
    {
            $getAlreadyFirst = Class_Subject :: getAlreadyFirst($request->class_id, $request->subject_id);
            if(!empty($getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();

                    return redirect('admin/assign_subject/list')->with('success', 'Status Updated Successfully!');
                }
                else
                {
                    $subjectclss =Class_Subject::getSingle($id);
                    $subjectclss->class_id = $request->class_id;
                    $subjectclss->subject_id = $request->subject_id;
                    $subjectclss->status = $request->status;
                                    $subjectclss->save();

                    return redirect('admin/assign_subject/list')->with('success', 'Subject Assign Updated Successfully!');
                }



    }



}
