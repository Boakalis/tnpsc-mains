<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamResource;
use App\Http\Resources\PlanResource;
use App\Http\Resources\TestResource;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ImageUpload;
use App\Models\Order;
use App\Models\SubmittedTest;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Str;


class CourseApiController extends Controller
{
    public function getExams()
    {
        if (auth('api')->user() != null ) {
            $purchaseCourse = Order::where([['user_id',auth('api')->user()->id],['status',1]])->pluck('course_id')->toArray();
            $exams = Course::whereIn('id',$purchaseCourse)->pluck('exam_id')->unique()->toArray();
            $datas = Exam::where('status', 1)->get();
            foreach ($datas as $key => $value) {
                if (in_array($value->id,$exams)) {
                    $value['course_purchase'] = 1;
                }else{
                    $value['course_purchase'] = 0;
                }
                foreach($value->courses as $course){
                    if (in_array($course->id , $purchaseCourse)) {
                        $value['course_purchased_url'] = $course->name;
                    }
                }
            }

        }else{
            $datas = Exam::where('status', 1)->get();
            foreach ($datas as $key => $value) {
                    $value['course_purchase'] = 0;
            }

        }
        return ExamResource::collection($datas);
    }

    public function getCourse($package, $course)
    {
        $str = trim($package);
        $examId = Exam::where('slug', $course)->pluck('id')->first();
        $tests = Course::where('exam_id', $examId)->where('slug',$package)->with(['formatedTest' => function ($query) {
            $query->where('status', '!=', 0);
        }])->first();
        if (auth('api')->user() != null ) {
            if (Order::where([['user_id',auth('api')->user()->id],['course_id',$tests->id],['status',1]])->exists()) {
                $tests['purchased'] = true;
            }else{
                $tests['purchased'] = false;
            }
        }else{
            $tests['purchased'] = false;
        }
        if (auth('api')->user() != null) {
            foreach ($tests->formatedTest as $test) {
                $isTestAttended = SubmittedTest::where([['user_id',auth('api')->user()->id],['test_id',$test->id]])->first();
                $test['test_attended'] = $isTestAttended != null ? true : false;
            }
        }
        $tests['weeks_wise'] = array_chunk($tests->formatedTest->toArray(), 6);
        return new TestResource($tests);
    }

    public function getPlans($slug)
    {
        $id = Exam::where('slug', $slug)->pluck('id')->first();
        return PlanResource::collection(Course::where('exam_id', $id)->get());
    }

    public function getQuestion(Request $request, $id)
    {
        $file = Test::where('id', $id)->first();
        $headers = array('Content-Type:application/pdf');
        $route = public_path() . '/storage/' . $file->file;
        return response()->download($route, 'pdf', $headers);
    }

    public function getSchedule(Request $request, $id)
    {
        $file = Course::where('id', $id)->first();
        $headers = array('Content-Type:application/pdf');
        $route = public_path() . '/storage/' . $file->days;
        return response()->download($route, 'pdf', $headers);
    }

    public function submitQuestion(Request $request)
    {
        try {
            if ($request->has('file')) {
                $image =   ImageUpload::upload($request->file ,auth('api')->user()->id.Carbon::now()->format('dMY').'ID'.$request->id.'RAN'.rand(0,999));
            }

            SubmittedTest::create([
                'test_id' => $request->id,
                'user_id' => auth('api')->user()->id,
                'unique_id' => strtoupper(Str::random(30).Carbon::now()->format('dMYHis')),
                'submited_file' => $image,
            ]);

            return response()->json([
                'status' => 'ok',
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function getAnswer($id)
    {

        $test = SubmittedTest::where([['user_id',auth('api')->user()->id],['test_id',$id]])->orderBy('id','DESC')->first();

        if ($test == null) {
            $headers = [
                'Content-Type'=>'application/json',
            ];
            return response()->json([
                'message'=> 'Please submit test before request'

            ])->setStatusCode(401);
        }

        if ($test->evaluated_file == null) {
            return response()->json([
                'message'=> 'Result Not yet available'
            ])->setStatusCode(403);
        }

        $file = SubmittedTest::where([['user_id', auth('api')->user()->id],['test_id',$id]])->orderBy('id','DESC')->first();
        $route = public_path() . '/storage/' . $file->file;
        $headers = ['Content-Type: application/pdf'];


        return response()->download(public_path('storage/'.$file->evaluated_file), 'new',$headers);

    }

}
