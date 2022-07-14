<?php

//ورودی های سامانه شتاب
//transaction_time زمان ارسال درخواست
//transaction_number شماره تراکنش
//transaction_type نوع تراکنش

$transaction_time = $_POST['transaction_time'];

$condition = "exist";
if ((time() - $transaction_time) < 15) {

    $transaction_type = $_POST['transaction_type'];
    $transaction_number = $_POST['transaction_number'];

    if ($transaction_type != "لغو تراکنش") {

        $json_arr = json_decode(file_get_contents("transactions.json"), true);

        $json_arr[$transaction_number] = [$transaction_time, $condition];

        file_put_contents("transactions.json", json_encode($json_arr, \JSON_UNESCAPED_UNICODE));
        echo " تراکنش با شماره " . (string)($transaction_number) . " ثبت شد ";
    } else {

        $json = file_get_contents("transactions.json");
        $json_arr = json_decode($json, true);
        if (isset($json_arr[$transaction_number])) {
            if ($json_arr[$transaction_number][1] == "notexist") {
                echo "تکراری";
            } else {
                echo " تراکنش با شماره " . (string)($transaction_number) . " لغو شد ";
                $json_arr[$transaction_number][1] = "notexist";
                file_put_contents("transactions.json", json_encode($json_arr, \JSON_UNESCAPED_UNICODE));
            }
        } else {
            echo "نادرست";
        }
    }
}
