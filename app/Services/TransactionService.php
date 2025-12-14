<?php

use App\Models\Transactions;
use App\Services\BaseService;
use App\Utils\AppUtils;

class TransactionService extends BaseService
{
    public const MSG_NOT_FOUND = "transaction not found!";
    public function __construct(AppUtils $appUtils, Transactions $transactions)
    {
        parent::__construct($transactions, self::MSG_NOT_FOUND, $appUtils);
    }

    public function createTransaction(array $data)
    {
        return match ($data['method']) {
            "stripe" => $this->handleStripe(),
            "paypal" => $this->handlePaypal(),
            default => parent::create($data)
        };
    }

    private function handleStripe()
    {

    }
    private function handlePaypal()
    {

    }
}