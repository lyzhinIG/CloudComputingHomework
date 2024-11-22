<?php
require_once './db.php';

CONST N=2147683640;

function dataClean($str){
    $str=htmlspecialchars($str, ENT_QUOTES);
    $str=preg_replace('/[^0-9-]/', '', $str);
    return (int)$str;
}

function addMesLog($mes){
    file_put_contents('../log/log.txt', "[".date("Y-m-d H:i:s")."] ".$mes."\n", FILE_APPEND | LOCK_EX);
}

function checkingThereNotNumber($db, $number){
    $stmt = $db->prepare('SELECT COUNT(`id`) as count_value  FROM `homework2` WHERE `value_number`=?');
    $stmt->execute([$number]);
    $data = $stmt->fetch();
    if(isset($data->count_value)){
        if($data->count_value>0){
            return false;
        } else{
            return true;
        }
    } else {
        return false;
    }
}

function addNumberDataBase($db, $number){
    $stmt = $db->prepare('INSERT INTO `homework2` (`value_number`) VALUES (?)');
    $stmt->bindValue(1,$number,PDO::PARAM_INT);
    $stmt->execute();
}




function validateNumberField() {
    $A = array(
        'status' => false,
        'value' => -1,
        'info' => ''
    );
    if (!isset($_POST['number'])) {
        $A['info'] = $A['info'].' There is no field "number" (нет нужного поля в запросе).';
        $A['status'] = false;
    } else {
        $value = dataClean($_POST['number']);
        //var_dump($value,$_POST['number'],strval($value));
        if (strval($value)==$_POST['number']) {
            $A['value']=$value;
            if ($value>0 and $value<N){
                $A['status'] = true;
            } else{
                $A['info'] = $A['info'].' The number is not in the required range(число меньше 0 или больше N).';
                $A['status'] = false; 
            }
        } else {
            $A['info'] = $A['info'].' The data sent is not a number(прислали не число).';
            $A['status'] = false;
        }
    }
    return $A;
}


function dataProcessing(){
    $data = validateNumberField();
    $answer =  array();
    $answer['status'] = 500;
    if($data['status']){
        $db = dbConnect();
        if (checkingThereNotNumber($db,$data['value'])){
            if (checkingThereNotNumber($db,$data['value']+1)){
                addNumberDataBase($db,$data['value']);
                $answer['status'] = 200;
                $answer['newValue'] = $data['value']+1;
            } else {
                $answer['status'] = 400;
                $answer['description'] = "current number that is one less than an existing number(число на едицицу меньше, чем уже существующее)";
                addMesLog($answer['description']."| value = ".$data['value']);
            }

        } else {
            $answer['status'] = 400;
            $answer['description'] = "the number was already there(число уже было)";
            addMesLog($answer['description']."| value = ".$data['value']);
        }
    } else {
        $answer['status'] = 400;
        $answer['description'] = $data['info'];
    }
    return $answer;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataOutProcessing=dataProcessing();
    if($dataOutProcessing['status']==400){
        echo 'Ошибка. Error. '.$dataOutProcessing['description'];
    } else {
        if($dataOutProcessing['status']==200){
            echo $dataOutProcessing['newValue'];
        } else {
            echo 'Неизвестная ошибка. Unknown error.';
        }
    }
} else {
    echo "Hello world";
}
