<?php

/*40 じゃんけんを作成しよう！
下記の要件を満たす「じゃんけんプログラム」を開発してください。
要件定義
・使用可能な手はグー、チョキ、パー
・勝ち負けは、通常のじゃんけん
・PHPファイルの実行はコマンドラインから。
ご自身が自由に設計して、プログラムを書いてみましょう！*/

//修正点：validation関数で再帰関数を使用せずバリデーションのみを行う
//修正点：retryは使用せず、再帰処理はrockPaperScissors関数にいれる
//追加：判定が終了したらゲームを続けるか確認する

//テスト


const HAND_TYPE = array('グー','チョキ','パー');
const RESULT = array('勝ち', '負け', 'あいこ');
const ANSWER = array('はい','いいえ');

//バリデーション関数
function validation($player_hand, $array){
    if(empty($player_hand)){
        echo '入力内容が空です。' . PHP_EOL;
        return false;
    }
    //入力値が配列に含まれるか確認
    if((in_array($player_hand, $array, true)) === false){
        echo '入力した内容に誤りがあります。' . PHP_EOL;
        return false;
    }
    return true;
}

//自分の手を入力
function selectHand(){
    echo '手を入力してください。' . PHP_EOL;
    $player_hand = trim(fgets(STDIN));
    $check = validation($player_hand,HAND_TYPE);
    if(!$check){
        return selectHand();
    }
    return $player_hand;
}

//相手の手を入力
function getComHand(){
    $com_key = array_rand(HAND_TYPE);
    $com_hand = HAND_TYPE[$com_key];
    echo "相手の手は{$com_hand}です。" . PHP_EOL;
    return $com_key;
}

//判定
function judge($myhand, $com_hand){
    $mykey = array_keys(HAND_TYPE, $myhand);
    $myhand = $mykey[0];
    $cal = ($myhand - $com_hand + 3 ) % 3;
    switch ($cal) {
        case 0:
        //あいこ
          $result = 2;
          break;
        case 1;
        //負け
          $result = 1;
          break;
        case 2;
        //勝ち
          $result = 0;
          break;
    }
    return $result;
}

//勝敗表示
function show($result){
    $result_text = RESULT[$result];
    echo "結果：{$result_text}";
    return $result;
}

//ゲームを続けるか確認
function retry(){
    echo 'ゲームを続けますか。はい、いいえで入力してください。';
    $answer = trim(fgets(STDIN));
    $check = validation($answer, ANSWER);
    if(!$check){
        return retry();
    }
    $answer_key = array_keys(ANSWER, $answer);
    $answer = $answer_key[0];
    if($answer === 0){
        return true;
    }
    return false;
}

function rockPaperScissors(){
    $myhand = selectHand();
    $com_hand = getComHand();

    //判定
    $result = judge($myhand, $com_hand);

    //勝敗表示
    show($result);

    //あいこなら再帰関数
    if($result === 2){
        return rockPaperScissors();
    }

    //ゲームを続けるか確認
    $check_retry = retry();
    if($check_retry){
        return rockPaperScissors();
    }

}

echo 'じゃんけんをします。';
rockPaperScissors();



//じゃんけん関数
/*function rockPaperScissors(){
    $hand = array('グー','チョキ','パー');
    $player_hand = trim(fgets(STDIN));

     //入力値が空ではないか確認
     if(empty($player_hand)){
         echo '入力内容が空です。再度入力してください。' . PHP_EOL;
         return rockPaperScissors();
     }
     //入力値が配列に含まれるか確認
     if((in_array($player_hand, $hand, true)) === false){
         echo '入力した手は「グー、チョキ、パー」いずれにも該当しません。再度入力してください。' . PHP_EOL;
         return rockPaperScissors();
     }

     //相手の手をランダムに入力
     $com_key = array_rand($hand);
     $com_hand = $hand[$com_key];
     echo "相手の手は{$com_hand}です。" . PHP_EOL;

     //計算
     if($player_hand === $com_hand){
         echo 'あいこです。再度じゃんけんするので、再度手を入力してください。' . PHP_EOL;
         return rockPaperScissors();
     }elseif(
         $player_hand === 'グー' && $com_hand === 'チョキ' ||
         $player_hand === 'チョキ' && $com_hand === 'パー' ||
         $player_hand === 'パー' && $com_hand === 'グー'
     ){
         echo 'おめでとう、勝ちました！' . PHP_EOL;
     }else{
         echo '残念、負けました。' . PHP_EOL;
     }
}

echo 'じゃんけんを始めます。グーチョキパーいずれかの手を入力してください。' . PHP_EOL;
rockPaperScissors();*/

 ?>
