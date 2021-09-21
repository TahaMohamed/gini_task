<?php

namespace Task\Bank\Contracts;
/**
 * Bank Operations
 */
abstract class BankOperation
{
    public $deposit_fee = 0.0003;
    public $eur_exchange_rate = ['JPY' => 129.53,'USD' => 1.1497];

    public function depositFee($fee)
    {
        $this->deposit_fee = $fee / 100;
        return $this;
    }

    public function deposit($transactions)
    {
        $output = [];
        foreach ($transactions as $transaction) {
            $amount = $this->convertCurrencyToEUR($transaction['amount'],$transaction['currency']);

            $commission_amount = bcmul($this->deposit_fee, $amount,2);

            $output[$transaction['id']] = $this->convertEurToCurrency($commission_amount,$transaction['currency']);
            // $output[] = $this->getNumberFormat($commission_amount);
        }
        return $output;
    }

    public function convertCurrencyToEUR($mount,$from_currency)
    {
        switch ($from_currency) {
            case 'JPY':
                return bcdiv($mount,$this->eur_exchange_rate['JPY'],2);
            case 'USD':
                return bcdiv($mount,$this->eur_exchange_rate['USD'],2);
            default:
                return $mount;
        }
    }

    public function convertEurToCurrency($mount,$to_currency)
    {
        switch ($to_currency) {
            case 'JPY':
                return bcmul($mount,$this->eur_exchange_rate['JPY'],2);
            case 'USD':
                return bcmul($mount,$this->eur_exchange_rate['USD'],2);
            default:
                return $mount;
        }
    }

    public function getNumberFormat($number)
    {
        if (@strstr($number,'.')[3] > 0) {
            return bcadd($number ,0.01 , 2);
        }else{
            return (float)number_format($number,2);
        }
    }


    public abstract function withdrawFee($withdraw_fee);

    public abstract function withdraw($transactions);
}
