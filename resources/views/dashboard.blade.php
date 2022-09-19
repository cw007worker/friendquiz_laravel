@extends('Layout.canvas')

@section('content')

<div class="game-banner">
    <div class="section-ad">

    </div>

    <div class="section-game my-5 bg-grey">
        <h5 class="text-center fw-bold fs-2">
        <?php
            foreach($participant_info as $key => $value){
            echo $value->name;
            }?>のフレンドボード</h5>
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
                <tr>
                    <th scope="row">ffds</th>
                    <td>check</td>
                    <td>check</td>
                    <td><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"> <g> <path fill="none" d="M0 0h24v24H0z"/> <path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-4.586 6l1.768 1.768-1.414 1.414L12 15.414l-1.768 1.768-1.414-1.414L10.586 14l-1.768-1.768 1.414-1.414L12 12.586l1.768-1.768 1.414 1.414L13.414 14zM9 4v2h6V4H9z"/> </g> </svg></td>
                </tr>
            </tbody>
        </table>


    </div>


    <div class="section-game my-0 bg-grey">

        <div class="game-rules">
            <p class="text-center fs-9 fw-regular">
                さぁ、あなたのクイズのリンクを友達に送りましょう!
            </p>
        </div>


        <div class="game-start row py-4">
            <div class="col text-center">
                <a href="javascript:void(0)" class="btn btn-primary fs-4 btn-start text-info fw-bold">
                    リンクをコピーする
                </a>
            </div>
        </div>


    </div>

    <div class="game-start row py-5">
        <div class="col text-center">
            <a href="javascript:void(0)" class="btn outline-btn-yellow fw-bold delete-btn">
                削除・新しいクイズを作成する
            </a>
        </div>
    </div>

</div>

@stop
