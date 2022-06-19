<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    //this controller handles
    // creating a survey
    // showing a survey to be filled
    // receiving responses

    public function create(Request $request)
    {
        $request->json($request->all());
        if (!$request->title) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Every survey must include a title',
            ]);
        }

        $survey = Survey::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
        ]);

        foreach ($request->questions as $question) {
            $q = Question::create([
                'survey_id' => $survey->id,
                'type' => $question['type'],
                'content' => $question['content'],
            ]);
            foreach ($question['options'] as $option) {
                Option::create([
                    'question_id' => $q->id,
                    'value' => $option,
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully created survey',
            'survey_id' => $survey->id,
            // TODO
            // return url of survey to be shared
        ]);
    }


    public function show($id)
    {
        $survey = Survey::where('id', $id)->with('questions', 'questions.options')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully retrieved survey',
            'survey' => $survey,
            'survey_url' => 'temp_url'
            // TODO
            // return url of survey to be shared
        ]);
    }

    // TODO finish this
    public function list(Request $request)
    {
        // $user = Auth::user();
        $user = auth()->user();
        $surveys = auth()->user()->surveys()->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully retreived all your surveys',
            'survey' => $surveys

        ]);
    }
    public function respond(Request $request)
    {
        $request->json($request->all());
        // return $request;
        // return response()->json($request->all());

        $response = Response::create([
            'user_id' => Auth::user()->id,
            'survey_id' => $request->survey_id,
        ]);

        foreach ($request->answers as $answer) {
            $a = Answer::create([
                'response_id' =>  $response->id,
                'question_id' => $answer['question_id'],
                'type' => $answer['type'],
                'content' => $answer['content'],
            ]);
            foreach ($answer['options'] as $option) {
                DB::insert('insert into answers_options (answer_id, option_id) values (?, ?)', [$a->id,  $option]);
            }
        }
        // TODO
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully submitted response',
            // 'survey' => $survey,

        ]);
    }
    // TODO test this
    public function results(Request $request)
    {

        $survey = Survey::where('id', $request->id)->with('questions', 'questions.options', 'responses', 'responses.answers', 'responses.answers.options')->get();

        if ($survey[0]->user_id == Auth::user()->id) {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully retrieved survey with all responses',
                'survey' => $survey,
                // TODO
                // return url of survey to be shared
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'You are not authorized to view this page',
        ]);
    }
}
