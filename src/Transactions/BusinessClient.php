<?php

namespace Task\Bank\Transactions;

use Task\Bank\Contracts\BankOperation;
/**
 * Deal with Business Accounts
 */
class BusinessClient extends BankOperation
{
    public $withdraw_fee = 0.005;

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

    public function withdrawFee($fee)
    {
        $this->withdraw_fee = $fee / 100;
        return $this;
    }

    public function withdraw($transactions)
    {
        $output = [];
        foreach ($transactions as $transaction) {
            $amount = $this->convertCurrencyToEUR($transaction['amount'],$transaction['currency']);

            $commission_amount = bcmul($this->withdraw_fee, ($amount - 1000),2);

            $output[$transaction['id']] = $this->convertEurToCurrency($commission_amount,$transaction['currency']);
        }

        return $output;
    }

}
