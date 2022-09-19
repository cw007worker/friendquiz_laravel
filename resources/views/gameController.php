<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\quiz;
use App\Models\participant;
use App\Models\answer;
use Carbon\Carbon;
use Redirect;
use Session;


class gameController extends Controller
{
    public function index(Request $req){
        if(!empty($req->player_name)){
            $player_name = $req->player_name;
            $game_id = $req->game_id;
            $questions = quiz::select('questions')->where('quiz_id', '=', $game_id)->get();
            

            if($questions->count()){
                $data_arr = json_decode($questions[0]['questions'], true);


                if($req->ajax()){
                    return response()->json([
                        'data' => $data_arr
                    ]);
                }else{
                    return view('playground', ['game_id' => $game_id, 'player_name' => $player_name]);
                }

            }else{
                return redirect()->back()->with('error', 'Game not found!'); 
            }
        }

        return redirect()->back()->with('error', '名前を入力してください');  

    }


    public function createQuiz(Request $req){
        
        $data = $req->all();
        $game_id = $data['game_id'];
        $player_name = $data['player_name'];
        $exam_id = $data['exam_id'];
        $group_id = bin2hex(random_bytes(5));
        $ansers_arr = json_encode($data['ansers_arr']);
        $share_link = bin2hex(random_bytes(4));
        $frnd_board_link = bin2hex(random_bytes(4));
        $dashboard_link = bin2hex(random_bytes(8));

        //fix the key
        $x[] = $data['ansers_arr'][array_key_last($data['ansers_arr'])];

        $merge = array_merge($data['ansers_arr'], $x);

        $create_participant = participant::insert([
            'exam_id' => $exam_id,
            'game_id' => $game_id,
            'name' => $player_name,
            'creator' => '1',
            'share_link' => $share_link,
            'frnd_board_link' => $frnd_board_link,
            'dashboard_link' => $dashboard_link,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if($create_participant){

            $create_answer = answer::insert([
                'exam_id' => $exam_id,
                'quiz_id' => $game_id,
                'answers' => json_encode($merge),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }


        
        return response()->json([
            'status' => 200,
            'share_link' => $share_link,
            'friend_board_link' => $frnd_board_link,
            'user_dashboard_link' => $dashboard_link,
            'exam_id' => $exam_id,
        ]);
    }


    public function shareQuiz(Request $req){

        if(!empty($req->quiz) && !empty($req->invite)){
            $exam_id = $req->quiz;
            $participant_info = participant::where('exam_id', $exam_id)->take(1)->get();


            if($participant_info->count()){
                return view('shareQuiz', compact('participant_info'));
            }
            
        }

        return view('homepage');

    }


    public function retakeQuiz(Request $req){
        if(!empty($req->invite)){
            $invite_id = $req->invite;
            $participant_info = participant::where('share_link', $invite_id)->take(1)->get();



            if($participant_info->count()){
                return view('homepageRetake', compact('participant_info'));
            }

        }
            
        return view('homepage');
        
    }


    public function retakeQuizStart(Request $req){

        if(!empty($req->invite) && !empty($req->player_name)){
            $player_name = $req->player_name;
            $game_id = $req->game_id;
            $invite_id = $req->invite;

            $fetch_exam_id = participant::where('share_link', $invite_id)->take(1)->pluck('exam_id')->toArray();
            $fetch_creator_name = participant::where('share_link', $invite_id)->take(1)->pluck('name')->toArray();

            $questions = quiz::select('questions')->where('quiz_id', '=', $game_id)->get();
            $answers = answer::select('answers')->where('exam_id', '=', $fetch_exam_id[0])->get();

            
            if($questions->count()){
                $data_arr_q = json_decode($questions[0]['questions'], true);
                $data_arr_a = json_decode($answers[0]['answers'], true);

                

                $data_arr = [];
                for($i= 0; $i < count($data_arr_q['data']); $i++){
                    for($j= 0; $j < count($data_arr_a); $j++){
                        if($data_arr_q['data'][$i]['id'] == $data_arr_a[$j]['question_key']){
                            $data_arr_q['data'][$i]['question_retake'] = str_replace("@quizCreator@", $fetch_creator_name[0], $data_arr_q['data'][$i]['question_retake']);
                            $data_arr_q['data'][$i]['answer_key'] = $data_arr_a[$j]['answer_key'];
                            $data_arr['data'][] = $data_arr_q['data'][$i];
                        }
                    }
                }
                
            

                if($req->ajax()){
                    return response()->json([
                        'data' => $data_arr
                    ]);
                }else{
                    return view('playgroundSecondary', ['game_id' => $game_id, 'player_name' => $player_name, 'invite' => $invite_id]);
                }

            }
        }
            
        return view('homepage');
        
    }


    public function retakeQuizCreate(Request $req){


        $data = $req->all();
        $game_id = $data['game_id'];
        $player_name = $data['player_name'];
        $exam_id = $data['exam_id'];
        $ansers_arr = json_encode($data['ansers_arr']);
        $share_link = $data['invite'];
        $frnd_board_link = '';
        $dashboard_link = '';

        $create_participant = participant::insert([
            'exam_id' => $exam_id,
            'game_id' => $game_id,
            'name' => $player_name,
            'creator' => '0',
            'share_link' => $share_link,
            'frnd_board_link' => $frnd_board_link,
            'dashboard_link' => $dashboard_link,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if($create_participant){

            $create_answer = answer::insert([
                'exam_id' => $exam_id,
                'quiz_id' => $game_id,
                'answers' => $ansers_arr,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }


        
        return response()->json([
            'status' => 200,
            'exam_id' => $exam_id,
        ]);
    }


    public function retakeQuizEnd(Request $req){
        //generate results
        $exam_id = $req->quiz_id;
        $group_id = participant::where('exam_id', $exam_id)->pluck('share_link')->toArray();
        $creator_exam_id = participant::where('share_link', $group_id)->where('creator', 1)->pluck('exam_id')->toArray();
        $creator_name = participant::where('share_link', $group_id)->where('creator', 1)->pluck('name')->toArray();

        $creator_answers = answer::select('answers')->where('exam_id', '=', $creator_exam_id[0])->get();
        $creator_answers_arr = json_decode($creator_answers[0]["answers"], true);

        $this_answers = answer::select('answers')->where('exam_id', '=', $exam_id)->get();
        $this_answers_arr = json_decode($this_answers[0]["answers"], true);

        $corrent_answer = 0;
        $wrong_answer = 0;
        for($i = 0; $i < 10; $i++){
            for($j = 0; $j < 10; $j++){
                if($creator_answers_arr[$i]['question_key'] == $this_answers_arr[$j]['question_key']){
                    if($creator_answers_arr[$i]['answer_key'] == $this_answers_arr[$j]['answer_key']){
                        $corrent_answer++;
                    }else{
                        $wrong_answer++;
                    }
                }
            }
        }

        $current_user_result = $corrent_answer;


        $group_results = participant::select('exam_id', 'name')->where('share_link', $group_id)->where('creator', 0)->get();


        $result_arr = [];
        foreach($group_results as $key => $value){

            $this_answers = answer::select('answers')->where('exam_id', '=', $value->exam_id)->get();
            $this_answers_arr = json_decode($this_answers[0]["answers"], true);

            $corrent_answer = 0;
            $wrong_answer = 0;
            $all_results = [];
            for($i = 0; $i < 10; $i++){
                for($j = 0; $j < 10; $j++){
                    if($creator_answers_arr[$i]['question_key'] == $this_answers_arr[$j]['question_key']){
                        if($creator_answers_arr[$i]['answer_key'] == $this_answers_arr[$j]['answer_key']){
                            $corrent_answer++;
                        }else{
                            $wrong_answer++;
                        }
                    }
                }

                
            }
            
            $result_arr[] = array('name' => $value->name, 'marks' => $corrent_answer);
            
        }

                $marks_sort = array();
                foreach ($result_arr as $key => $row)
                {
                    $marks_sort[$key] = $row['marks'];
                }
                array_multisort($marks_sort, SORT_DESC, $result_arr);


        return view('gameEnd', ['marks' => $current_user_result, 'creator_name' => $creator_name[0], 'all_result' => $result_arr, 'total_marks' => '10']);
    }


    public function friendBoard(Request $req){
        if(!empty($req->access)){
            $access = $req->access;
            $participant_info = participant::where('frnd_board_link', $access)->take(1)->get();

            if($participant_info->count()){

                $group_id = participant::where('frnd_board_link', $access)->pluck('share_link')->toArray();
                $creator_exam_id = participant::where('share_link', $group_id)->where('creator', 1)->pluck('exam_id')->toArray();
                $creator_name = participant::where('share_link', $group_id)->where('creator', 1)->pluck('name')->toArray();
        
                $creator_answers = answer::select('answers')->where('exam_id', '=', $creator_exam_id[0])->get();
                $creator_answers_arr = json_decode($creator_answers[0]["answers"], true);

        
        
                $group_results = participant::select('exam_id', 'name')->where('share_link', $group_id)->where('creator', 0)->get();
        
        
                $result_arr = [];
                foreach($group_results as $key => $value){
        
                    $this_answers = answer::select('answers')->where('exam_id', '=', $value->exam_id)->get();
                    $this_answers_arr = json_decode($this_answers[0]["answers"], true);
        
                    $corrent_answer = 0;
                    $wrong_answer = 0;
                    $all_results = [];
                    for($i = 0; $i < 10; $i++){
                        for($j = 0; $j < 10; $j++){
                            if($creator_answers_arr[$i]['question_key'] == $this_answers_arr[$j]['question_key']){
                                if($creator_answers_arr[$i]['answer_key'] == $this_answers_arr[$j]['answer_key']){
                                    $corrent_answer++;
                                }else{
                                    $wrong_answer++;
                                }
                            }
                        }
        
                        
                    }
                    
                    $result_arr[] = array('name' => $value->name, 'marks' => $corrent_answer);
                    
                }


                $marks_sort = array();
                foreach ($result_arr as $key => $row)
                {
                    $marks_sort[$key] = $row['marks'];
                }
                array_multisort($marks_sort, SORT_DESC, $result_arr);



                return view('friendBoard', ['share_link' => $group_id[0], 'creator_name' => $creator_name[0], 'all_result' => $result_arr, 'total_marks' => '10']);
            }
            
        }
        
        return view('homepage');
        
    }






}