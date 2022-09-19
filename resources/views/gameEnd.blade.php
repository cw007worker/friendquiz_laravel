@extends('Layout.canvas')

@section('content')

<div class="game-banner">
    <div class="section-ad">

    </div>


    <div class="section-game my-0 bg-grey">

        <div class="game-rules">
            <p class="text-center fs-3 fw-bold">
                雪おめでとうあつ!
            </p>

            <p class="text-center fs-4 fw-bold"> あなたは奈美に関するクイズで<br>{{$marks}}/10点獲得しました。</p>

            <p class="text-center fs-4 fw-regular"> さぁ 次はあなた自身のクイズを作成して 友達にシェアしましょう!</p>
        </div>


        <div class="game-start row py-4">
            <div class="col text-center">
                <a href="/" class="btn btn-primary fs-4 btn-start text-info fw-bold">
                    自分のクイズを作成する
                </a>
            </div>
        </div>


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
                    
                </tr>
                <?php }
                    ?>
            </tbody>
        </table>


    </div>

</div>

@stop
