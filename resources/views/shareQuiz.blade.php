@extends('Layout.canvas')

@section('content')

<div class="game-banner">
    <div class="section-ad">

    </div>

        <div class="game-rules">
            <p class="text-center fs-3 fw-bold">
                <span class="is_player_name">
                    <?php
                        foreach($participant_info as $key => $value){
                            echo $value->name;
                        }
                    ?>
                </span>についてのクイズができました!受
            </p>
        </div>

    <div class="section-game my-0 bg-grey">

        <div class="game-rules">
            <p class="text-center fs-9 fw-regular">
                さぁ、あなたのクイズのリンクを友達に送りましょう!
            </p>
        </div>

        <form>
            <div class="form-group">
                <input type="text" class="form-control text-center text-muted" id="copy_field" value="<?php
                        foreach($participant_info as $key => $value){
                            echo URL::to('/') . '/playground/?invite=' . $value->share_link;
                        }
                    ?>" readonly>
                    <p id="link-copied-text" class="form-group text-center text-danger my-1 fw-6"></p>
            </div>
        </form>

        <div class="game-start row py-4">
            <div class="col text-center">
                <a href="javascript:void(0)" class="btn btn-primary btn-start text-info fw-bold btn-to-copy">
                    リンクをコピーする
                </a>
            </div>
        </div>


    </div>

    <div class="game-start row py-4">
            <div class="col text-center">
                <a href="/friends-board?access=<?php foreach($participant_info as $key => $value){ echo $value->frnd_board_link;}?>" class="btn btn-primary btn-fade-yellow text-info fw-bold">
                    フレンドボードを見る
                </a>
            </div>
        </div>

</div>

@stop
