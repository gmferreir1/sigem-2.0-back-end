<?php

namespace Modules\Termination\Services;


use Carbon\Carbon;
use Modules\Sicadi\Repositories\ContractRepository;
use Modules\Sicadi\Repositories\ReceiptTenantCompleteRepository;

class RentAccessoryService
{
    /**
     * @var ReceiptTenantCompleteRepository
     */
    private $receiptTenantCompleteRepository;
    /**
     * @var ContractRepository
     */
    private $contractRepository;

    public function __construct(ReceiptTenantCompleteRepository $receiptTenantCompleteRepository, ContractRepository $contractRepository)
    {
        $this->receiptTenantCompleteRepository = $receiptTenantCompleteRepository;
        $this->contractRepository = $contractRepository;
    }

    public function getPaymentRentData(string $contract)
    {
        $contractData = $this->contractRepository->findWhere(['contract_code' => $contract]);
        $contractId = '';

        if (!$contractData->count()) {
            return '';
        }

        $contractId = $contractData[0]['contract_id'];


        $closure = function ($query) use ($contractId) {
            return $query->where('contract_id', $contractId)->whereNotNull('payment_date')->orderBy('due_date', 'DESC');
        };

        $paymentData = $this->receiptTenantCompleteRepository->skipPresenter(true)->scopeQuery($closure)->all();

        if (!$paymentData->count()) {
            return '';
        }

        return "Valor do aluguel R$ " . number_format($paymentData[0]['value_base'], 2, ',','.') . " - Ultimo valor pago R$ ".number_format($paymentData[0]['value_pay'], 2, ',','.') . " - Data vencimento ultimo aluguel: " . Carbon::createFromFormat('Y-m-d', $paymentData[0]['due_date'])->format('d/m/Y');
    }
}