<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class Class_Subject extends Model
{
    use HasFactory;

    protected $table = 'class__subjects';

    static public function getRecord()
    {
        return self::select('class__subjects.*', 'class.name as class_name', 'subjects.name as subject_name', 'users.name as created_by_name')
                    ->join('subjects', 'subjects.id', '=', 'class__subjects.subject_id')
                    ->join('class', 'class.id', '=', 'class__subjects.class_id')
                    ->join('users', 'users.id', '=', 'class__subjects.created_by')
                    ->where('class__subjects.is_delete', '=', 0)
                    ->orderBy('class__subjects.id', 'desc')
                    ->paginate(6);

    }

    static public function getAlreadyFirst($class_id , $subject_id)
    {
        return self::where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->first();
    }


    static public function getSingle($id)
    {
        return self::find($id);
    }


    static public function getAssignSubjectID($class_id)
    {
        return self::where('class_id', '=', $class_id)->where('is_delete', '=', 0)->get();
    }

    static public function deleteSubject($class_id)
    {
        return self::where('class_id', '=', $class_id)->delete();
    }

}
