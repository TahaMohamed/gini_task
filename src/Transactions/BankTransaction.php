<?php
namespace Task\Bank\Transactions;

class BankTransaction
{

    public function makeTransaction($transactions)
    {
        $filtered_transactions = $this->getClientTransactionsKeyByType($transactions);
        $business_transactions = (new BusinessClient)->makeTransaction($filtered_transactions['business']);
        $private_transactions = (new PrivateClient)->makeTransaction($filtered_transactions['private']);

        return $private_transactions+$business_transactions;

    }

    private function getClientTransactionsKeyByType($transactions)
    {
         foreach ($transactions as $element) {
              $result[$element['user_type']][] = $element;
          }
          return $result;
    }

}
