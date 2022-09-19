@extends('Layout.canvas')

@section('content')

<div class="game-banner">
    <div class="section-ad">

    </div>

    <div class="section-game">

        <div class="game-rules">
            <p class="text-center fs-3 fw-bold">
                <span>
                    <?php
                        foreach($participant_info as $key => $value){
                        echo $value->name;
                    }?>
                </span>
                のフレンドクイズ <br>😋遊び方😋
            </p>

            <ul class="rule">
                <li> <span>①</span> あなたの名前を入力しましょう</li>
                <li> <span>②</span> あなたの友達についてのクイズに答えてください</li>
                <li> <span>③</span> フレンドボードでスコアを確認しましょう</li>
            </ul>

            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 my-auto mx-auto">
                    <form class="form-inline text-center game-start" method="POST" action="{{URL::to('/playground');}}/start-game">
                        @csrf
                        <input type="hidden" id="game_id" name="game_id" value="142536">
                        <input type="hidden" id="invite" name="invite" value="<?php echo $_GET['invite'] ?>">
                        <input type="text" id="player_name" name="player_name" class="form-control text-center" placeholder="名前を入力してください (例 山田太郎)">
                        <div class="error_field">
                            <p class="error-text d-none py-3 my-0 text-danger fw-bold"></p>
                        </div>

                        @if (\Session::has('error'))
                        <div class="error_field">
                            <p class="error-text py-3 my-0 text-danger fw-bold">{!! \Session::get('error') !!}</p>
                        </div>
                        @endif

                    </form>
                </div>
            </div>

        </div>

        <div class="game-start row py-4">
            <div class="col text-center">
                <a href="javascript:void(0)" class="btn btn-primary btn-start text-info fw-bold">
                    スタート
                </a>
            </div>
        </div>


    </div>

</div>

@stop
