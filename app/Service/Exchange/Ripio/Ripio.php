<?php

namespace App\Service\Exchange\Ripio;

class Ripio
{
    use ApiUser,
        ApiAddress,
        ApiWithdrawal,
        ApiWithdrawalFee,
        ApiTransaction,
        ApiDeposit,
        ApiBalance,
        ApiRate,
        ApiReusableQuote;

    /** @var RipioClient $client */
    protected $client;

    public function __construct(RipioClient $client)
    {
        $this->client = $client;
    }
}
