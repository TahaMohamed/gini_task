<?php

namespace Task\Bank\Transactions;

use Task\Bank\Contracts\BankOperation;
/**
 * Deal with Private Accounts
 */
class PrivateClient extends BankOperation
{
    public $withdraw_fee = 0.003;

    public function withdrawFee($fee)
    {
        $this->withdraw_fee = $fee / 100;
        return $this;
    }

    public function withdraw($transactions)
    {
        $output = [];
        $prev_withdraws = 0;
        $client_week_transactions = $this->getClientWeekTransactions($transactions);
        foreach ($client_week_transactions as $week_transactions) {
            foreach ($week_transactions as $week_transaction) {
                $prev_withdraws = 0;
                foreach ($week_transaction as $transaction) {
                    $commission_amount = 0;

                    $amount = $this->convertCurrencyToEUR($transaction['amount'],$transaction['currency']);

                    $prev_withdraws += $amount;
                    $total_amount = $prev_withdraws + $amount;

                    if ($amount > 1000) {
                        $commission_amount = bcmul($this->withdraw_fee, ($amount - 1000),3);
                    }elseif ($total_amount > 1000) {
                        $commission_amount = bcmul($this->withdraw_fee, ($total_amount - $prev_withdraws),3);
                    }

                    $output[$transaction['id']] = $this->convertEurToCurrency($commission_amount,$transaction['currency']);
                }
            }
        }
        return $output;
    }

    public function makeTransaction($transactions)
    {
        $withdraw_transactions = array_filter($transactions,function ($trans) {
            return $trans['operation_type'] == 'withdraw';
        });

        $deposit_transactions = array_filter($transactions,function ($trans) {
            return $trans['operation_type'] == 'deposit';
        });
        return $this->withdraw($withdraw_transactions)+$this->deposit($deposit_transactions);
    }

    public function getClientWeekTransactions($transactions)
    {
        $byWeek = [];
        $byClient = [];
        foreach ($transactions as $transaction) {
            if(!isset($byClient[$transaction['client_id']])){
                $byClient[$transaction['client_id']] = [];
            }
            $byClient[$transaction['client_id']][] = $transaction;
        }

        foreach ($byClient as $client => $user_transactions) {
            foreach ($user_transactions as $transaction) {
                $date = \DateTime::createFromFormat('Y-m-d', $transaction['created_at']);

                $firstDayOfWeek = 1; // Monday

                $difference = ($firstDayOfWeek - $date->format('N'));
                if ($difference > 0) { $difference -= 7; }
                $date->modify("$difference days");
                $week = $date->format('W');
                if(!isset($byWeek[$client][$week])){
                    $byWeek[$client][$week] = [];
                }
                $byWeek[$client][$week][] = $transaction;
            }
        }
        return $byWeek;
    }
}
