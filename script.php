<?php
use Task\Bank\Transactions\BankTransaction;
$data = [
    ["id" => 1,"created_at" => "2014-12-31","client_id" => 4,"user_type" => "private","operation_type" => "withdraw","amount" => 1200.00,"currency" => "EUR"],
    ["id" => 2,"created_at" => "2015-01-01","client_id" => 4,"user_type" => "private","operation_type" => "withdraw","amount" => 1000.00,"currency" => "EUR"],
    ["id" => 3,"created_at" => "2016-01-05","client_id" => 4,"user_type" => "private","operation_type" => "withdraw","amount" => 1000.00,"currency" => "EUR"],
    ["id" => 4,"created_at" => "2016-01-05","client_id" => 1,"user_type" => "private","operation_type" => "deposit","amount" => 200.00,"currency" => "EUR"],
    ["id" => 5,"created_at" => "2016-01-06","client_id" => 2,"user_type" => "business","operation_type" => "withdraw","amount" => 300.00,"currency" => "EUR"],
    ["id" => 6,"created_at" => "2016-01-06","client_id" => 1,"user_type" => "private","operation_type" => "withdraw","amount" => 30000,"currency" => "JPY"],
    ["id" => 7,"created_at" => "2016-01-07","client_id" => 1,"user_type" => "private","operation_type" => "withdraw","amount" => 1000.00,"currency" => "EUR"],
    ["id" => 8,"created_at" => "2016-01-07","client_id" => 1,"user_type" => "private","operation_type" => "withdraw","amount" => 100.00,"currency" => "USD"],
    ["id" => 9,"created_at" => "2016-01-10","client_id" => 1,"user_type" => "private","operation_type" => "withdraw","amount" => 100.00,"currency" => "EUR"],
    ["id" => 10,"created_at" => "2016-01-10","client_id" => 2,"user_type" => "business","operation_type" => "deposit","amount" => 10000.00,"currency" => "EUR"],
    ["id" => 11,"created_at" => "2016-01-10","client_id" => 3,"user_type" => "private","operation_type" => "withdraw","amount" => 1000.00,"currency" => "EUR"],
    ["id" => 12,"created_at" => "2016-02-15","client_id" => 1,"user_type" => "private","operation_type" => "withdraw","amount" => 300.00,"currency" => "EUR"],
    ["id" => 13,"created_at" => "2016-02-19","client_id" => 5,"user_type" => "private","operation_type" => "withdraw","amount" => 3000000,"currency" => "JPY"]
];
// echo $argv[1];
$transaction_fees = (new BankTransaction)->makeTransaction($data);
ksort($transaction_fees);
foreach ($transaction_fees as $transaction_fee) {
    echo $transaction_fee."\n";
}
