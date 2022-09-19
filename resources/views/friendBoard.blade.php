@extends('Layout.canvas')

@section('content')

<div class="game-banner">
    <div class="section-ad">

    </div>

    <div class="section-game my-5 bg-grey">
        <h5 class="text-center fw-bold fs-5">
        {{$creator_name}}のフレンドボード</h5>
        <table class="table table-borderless table-sm">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">名前 </th>
                    <th scope="col">点数</th>
                    <th scope="col">削除</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($all_result as $key => $each){ ?>
                <tr>
                    <th scope="row">
                         <?php
                            if($key == 0 ){ ?>
                                <img src="https://baldrove.sirv.com/friendQuiz/01.png" style="width: 20px">
                            <?php }elseif($key == 1){ ?>
                                <img src="https://baldrove.sirv.com/friendQuiz/02.png" style="width: 20px">
                            <?php }elseif($key == 2){ ?>
                                <img src="https://baldrove.sirv.com/friendQuiz/03.png" style="width: 20px">
                            <?php }
                        ?></th>
                    <td><?php echo $each['name']; ?></td>
                    <td><?php echo $each['marks']; ?>/10</td>
                    <td>
                        <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-4.586 6l1.768 1.768-1.414 1.414L12 15.414l-1.768 1.768-1.414-1.414L10.586 14l-1.768-1.768 1.414-1.414L12 12.586l1.768-1.768 1.414 1.414L13.414 14zM9 4v2h6V4H9z" />
                            </g>
                        </svg>
                        </a>
                    </td>
                </tr>
                <?php }
                    ?>
            </tbody>
        </table>


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
                        echo URL::to('/') . '/playground/?invite=' . $share_link;?>" readonly>
                    <p id="link-copied-text" class="form-group text-center text-danger my-1 fw-6"></p>
            </div>
        </form>

        <div class="game-start row py-4">
            <div class="col text-center">
                <a href="javascript:void(0)" id="copy_field" class="btn btn-primary fs-4 btn-start text-info fw-bold btn-to-copy">
                    リンクをコピーする
                </a>
            </div>
        </div>


    </div>

    <div class="game-start row py-5">
        <div class="col text-center">
            <a href="javascript:void(0)" class="btn outline-btn-yellow fs-4 fw-bold quiz-delete-btn">
                削除・新しいクイズを作成する
            </a>
        </div>
    </div>

</div>

@stop
