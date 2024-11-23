<?php
require_once './db.php';

CONST N=2147683640;

function dataClean($str){
    $str=htmlspecialchars($str, ENT_QUOTES);
    $str=preg_replace('/[^0-9-]/', '', $str);
    return (int)$str;
}

function addMesLog($mes){
    $logFile = '../log/log.txt';
    $flagWriteLog=file_put_contents($logFile, "[".date("Y-m-d H:i:s")."] ".$mes."\n", FILE_APPEND | LOCK_EX);
    if ($flagWriteLog === false) {
        error_log("Failed to write to log file: $logFile");
    }
}

function checkingThereNotNumber($db, $number){
    $stmt = $db->prepare('SELECT COUNT(`id`) as count_value  FROM `homework2` WHERE `value_number`=?');
    $stmt->execute([$number]);
    $data = $stmt->fetch();
    if(isset($data->count_value)) {
        if($data->count_value<1){
            return true;
        }
    }
    return false;
}

function addNumberDataBase($db, $number){
    $stmt = $db->prepare('INSERT INTO `homework2` (`value_number`) VALUES (?)');
    $stmt->bindValue(1,$number,PDO::PARAM_INT);
    $flag=$stmt->execute();
    if (!$flag) {
        addMesLog("Failed to insert number(ошибка добавления числа): ".$number);
    }
    return $flag;
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
            if ($value>=0 and $value<=N) {
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
    $answer =  array('status'=>500);
    if (!$data['status']) {
        $answer['status'] = 400;
        $answer['description'] = $data['info'];
        return $answer;
    }
    $db = dbConnect();
    //число уже было
    if (!checkingThereNotNumber($db, $data['value'])) {
        $answer['status'] = 400;
        $answer['description'] = "the number was already there (число уже было)";
        addMesLog($answer['description'] . "| value = " . $data['value']);
        return $answer;
    }
    //число на единицу меньше, чем уже существующее
    if (!checkingThereNotNumber($db, $data['value'] + 1)) {
        $answer['status'] = 400;
        $answer['description'] = "current number that is one less than an existing number (число на единицу меньше, чем уже существующее)";
        addMesLog($answer['description'] . "| value = " . $data['value']);
        return $answer;
    }
    //добавление в БД
    if(addNumberDataBase($db, $data['value'])) {
        $answer['status'] = 200;
        $answer['newValue'] = $data['value'] + 1;
        return $answer;
    }
    return $answer;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataOutProcessing=dataProcessing();
    if($dataOutProcessing['status']==400){
        echo 'Ошибка. Error. '.$dataOutProcessing['description'];
    } else {
        if ($dataOutProcessing['status']==200) {
            echo $dataOutProcessing['newValue'];
        } else {
            echo 'Неизвестная ошибка. Unknown error.';
        }
    }
} else {
    echo "Hello world";
}