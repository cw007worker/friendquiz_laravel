import './bootstrap';
import '../sass/app.scss'
import { data } from 'jquery';


$(document).ready(function() {

    
    var clickSound = document.createElement('audio');
    clickSound.setAttribute('src', '/public/audio/click.wav');

    var selectSound = document.createElement('audio');
    clickSound.setAttribute('src', '/public/audio/select.mp3');

    var worngSound = document.createElement('audio');
    worngSound.setAttribute('src', '/public/audio/wrong.mp3');

    var successSound = document.createElement('audio');
    successSound.setAttribute('src', '/public/audio/correct.mp3');


    function copyToClipboard(text) {
        var textArea = document.createElement( "textarea" );
        textArea.value = text;
        document.body.appendChild( textArea );       
        textArea.select();
        try {
            clickSound.play();
           var successful = document.execCommand( 'copy' );
        } catch (err) {
           console.log('Oops, unable to copy',err);
        }    
        document.body.removeChild( textArea );
     }

    

    $("#player_name").keyup(function () {
        $(".is_player_name").text($("#player_name").val());
    });

    $(".btn-start").click(function () {
        var game_id = $("#game_id").val();
        var player_name = $("#player_name").val();
    
        $(".error-text").html('');
        if($("#player_name").val() == ''){
            worngSound.play();
            $(".error-text").removeClass('d-none');
            $(".error-text").html("名前を入力してください");
        }else{
            clickSound.play();
            setTimeout(function () { 
                $('form.game-start').submit();
            }, 400);
        }
    });


    var playgroundUrl = window.location.origin+'/start-game';
    if(window.location.href == playgroundUrl){
        var game_id = $("#game_id").val();
        var player_name = $("#player_name").val();
        var quiz_id = $("#quiz_id").val();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var question_data = $.parseJSON($.ajax({
            url:  window.location.origin+'/start-game',
            dataType: "json", 
            async: false,
            data: { 
                    "player_name": player_name, 
                    "game_id": game_id
                },
        }).responseText);

        var question_data_arr = question_data.data;
        

        var skipped = [];
        var answered = [];
        var jsonObj = [];
        $.each(question_data_arr.data, function(key,val) {
            var question_id = key+1;


            if(key == 0){
                var option = '';
                var selected_option = 0;
                $.each(val.option, function(key,val) {
                    selected_option++;
                    if(val.image == ''){
                        option += '<li class="option_item noimage" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                    }else{
                        option += '<li class="option_item" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5"><img src="'+val.image+'" alt="" width="30" class="rounded-5 py-2 px-2"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                    }
                });

                var paper = '<h5 class="question text-center fw-bold" data-question-key="'+question_id+'">'+val.question+'</h5><div class="row py-3"><div class="col text-center"><button class="btn btn-sm btn-light rounded-5 skipped">スキップする</button></div></div><ul class="option">'+option+'</ul>';
                paper = $.parseHTML(paper);
                $(".paper").empty().append(paper);

                return false
            }
        
        }); 


            var current_state = 0;
            var total_answered = 0;
            var total_ignored = 0;
            var disabled = '';
            $('body').on('click', '.option_item, .skipped', function() {

                var is_checked_skipped = $(this).hasClass('skipped');
                var is_checked_option_item = $(this).hasClass('option_item');
                var question_key = $(this).data('question-key');
                var answer_key = $(this).data('key');
                successSound.play();
                current_state++;

                if(total_ignored >= 4){
                    var disabled = 'disabled';
                }

                if(answered.length <= 9){
                    $.each(question_data_arr.data, function(key,val) {
                        var question_id = key+1;

                        if(key == current_state){
                            if(key == current_state && is_checked_skipped == true){
                                total_ignored++;
                                skipped.push(current_state);
                            }else if(key == current_state && is_checked_option_item == true){
                                total_answered++;
                                
                                $(".pagi"+current_state).addClass('active');
                                    answered.push(current_state);
    
                                    var item = {}
                                    item ["question_key"] = question_key;
                                    item ["answer_key"] = answer_key;
                                    jsonObj.push(item);
                                    
    
                                    if(total_answered == 10){
                                        var loading_effect = '<div class="loading"><div class="section-loading text-center"><img src="https://baldrove.sirv.com/friendQuiz/loading.gif" alt="" width="200"></div></div>';
                                            $(".game-banner").empty().append(loading_effect);


                                            var request = {
                                                ansers_arr : jsonObj,
                                                player_name: player_name,
                                                game_id: game_id,
                                                exam_id: quiz_id
                                            };

                            
                                                $.ajax({
                                                    type: 'POST',
                                                    data: request,
                                                    async: false,
                                                    url: window.location.origin+'/create-game',
                                                    dataType: 'json',
                                                    success: function (res) {
                                                        location.href =  window.location.origin+'/share?quiz='+res.exam_id+'&invite='+res.share_link;
                                                    },
                                                    error: function (res) {
                                                        console.log(res);
                                                    }
                                                });
                                                
                                    }
                            }


                            var option = '';
                            var selected_option = 0;
                            $.each(val.option, function(key,val) {
                                selected_option++;
                                if(val.image == ''){
                                    option += '<li class="option_item noimage" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                                }else{
                                    option += '<li class="option_item" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5"><img src="'+val.image+'" alt="" width="30" class="rounded-5 py-2 px-2"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                                }
                            });
        
                            var paper = '<h5 class="question text-center fw-bold" data-question-key="'+question_id+'">'+val.question+'</h5><div class="row py-3"><div class="col text-center"><button class="btn btn-sm btn-light rounded-5 skipped '+disabled+'">スキップする</button></div></div><ul class="option">'+option+'</ul>';
                            paper = $.parseHTML(paper);
                            $(".paper").empty().append(paper);
                        }


                    });
                }
            });


    }

    $(".delete-btn").click(function () {
        alert("Do you want to delete it?");
    });

    

    $(".btn-to-copy").click(function () {
        var clipboardText = "";
        clipboardText = $('#copy_field').val(); 
        copyToClipboard( clipboardText );
        $("#link-copied-text").empty().append('リンクをコピーされました');

    });



    var playgroundSecondaryUrl = window.location.origin+'/playground/start-game';
    if(window.location.href == playgroundSecondaryUrl){
        var game_id = $("#game_id").val();
        var player_name = $("#player_name").val();
        var quiz_id = $("#quiz_id").val();
        var invite_id = $("#invite").val();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var question_data = $.parseJSON($.ajax({
            url:  window.location.origin+'/playground/start-game',
            dataType: "json", 
            async: false,
            data: { 
                    "player_name": player_name, 
                    "game_id": game_id,
                    "invite": invite_id
                },
        }).responseText);

        var question_data_arr = question_data.data;



        var skipped = [];
        var answered = [];
        var jsonObj = [];
        $.each(question_data_arr.data, function(key,val) {
            var question_id = val.id;

            if(key == 0){
                var option = '';
                var selected_option = 0;
                $.each(val.option, function(key,val) {
                    selected_option++;
                    if(val.image == ''){
                        option += '<li class="option_item noimage" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5 card'+selected_option+'"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                    }else{
                        option += '<li class="option_item" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5 card'+selected_option+'"><img src="'+val.image+'" alt="" width="30" class="rounded-5 py-2 px-2"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                    }
                });

                var paper = '<h5 class="question text-center fw-bold" data-question-key="'+question_id+'">'+val.question_retake+'</h5><div class="row py-3"></div><ul class="option">'+option+'</ul>';
                paper = $.parseHTML(paper);
                $(".paper").empty().append(paper);

                return false
            }
        
        }); 




        var current_state = 0;
        var current_ans_state = -1;
        var total_answered = 0;
        $('body').on('click', '.option_item, .skipped', function() {
            var is_checked_skipped = $(this).hasClass('skipped');
            var is_checked_option_item = $(this).hasClass('option_item');
            var question_key = $(this).data('question-key');
            var answer_key = $(this).data('key');
            
            current_state++;
            current_ans_state++;
            total_answered++;

            if(answered.length <= 9){
                $.each(question_data_arr.data, function(key,val) {
                var question_id = val.id;

                    if(key == current_state){

                        if(key == current_state && is_checked_skipped == true){
                            
                            skipped.push(current_state);
                        }else if(key === current_state && is_checked_option_item == true){


                            $.each(question_data_arr.data, function(key,val) {
                                var correct_answer = val.answer_key;
                                if(key == current_ans_state){

                                    if(answer_key == correct_answer){
                                        successSound.play();
                                        $(".card"+answer_key).css("border", "#01cd01 solid 6px");
                                    }else{
                                        worngSound.play();
                                        $(".card"+correct_answer).css("border", "#01cd01 solid 6px");
                                        $(".card"+answer_key).css("border", "#cd0101 solid 6px");
                                    }
                                }
                            });

                            
                            
                            $(".pagi"+current_state).addClass('active');
                                answered.push(current_state);

                                var item = {}
                                item ["question_key"] = question_key;
                                item ["answer_key"] = answer_key;
                                jsonObj.push(item);
                                
            
                                if(total_answered == 10){

                                    setTimeout(function () {
                                        var loading_effect = '<div class="loading"><div class="section-loading text-center"><img src="https://baldrove.sirv.com/friendQuiz/loading.gif" alt="" width="200"></div></div>';
                                        $(".game-banner").empty().append(loading_effect);


                                        var request = {
                                            ansers_arr : jsonObj,
                                            player_name: player_name,
                                            game_id: game_id,
                                            exam_id: quiz_id,
                                            invite: invite_id
                                        };

                                        
                                            $.ajax({
                                                type: 'POST',
                                                data: request,
                                                async: false,
                                                url: window.location.origin+'/playground/create-game',
                                                dataType: 'json',
                                                success: function (res) {
                                                    location.href =  window.location.origin+'/playground/end-game?quiz_id='+res.exam_id;
                                                },
                                                error: function (res) {
                                                    console.log(res);
                                                }
                                            });
                                    }, 1000);     
                                }
                        }


                        var option = '';
                        var selected_option = 0;
                        $.each(val.option, function(key,val) {
                            selected_option++;
                            if(val.image == ''){
                                option += '<li class="option_item noimage" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5 card'+selected_option+'"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                            }else{
                                option += '<li class="option_item" id="option_item" data-question-key="'+question_id+'" data-key="'+selected_option+'"><div class="card rounded-5 card'+selected_option+'"><img src="'+val.image+'" alt="" width="30" class="rounded-5 py-2 px-2"><div class="card-body"><p class="card-text text-center">'+val.text+'</p></div></div></li>';
                            }
                        });
    
                        var paper = '<h5 class="question text-center fw-bold" data-question-key="'+question_id+'">'+val.question_retake+'</h5><div class="row py-3"></div></div><ul class="option">'+option+'</ul>';
                        paper = $.parseHTML(paper);


                        setTimeout(function () {
                            $(".paper").empty().append(paper);
                        }, 300);
                        
                    }


                });
            }
        });
        

    }
    

});




