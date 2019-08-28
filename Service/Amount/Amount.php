<?php

namespace Atournayre\ToolboxBundle\Service\Amount;

use Exception;

class Amount
{
    /**
     * @var int
     */
    private $outOfTaxes;

    /**
     * @var int
     */
    private $valueAddedTax;

    /**
     * @var int
     */
    private $valueAddedTaxPercent;

    /**
     * @var int
     */
    private $taxIncluded;

    /**
     * @var int
     */
    private $discount;

    /**
     * @var int
     */
    private $discountPercent;

    /**
     * @var int
     */
    private $discountedOutOfTaxes;

    /**
     * @var bool
     */
    private $applicableVAT;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $discountedAmount;

    /**
     * Amount constructor.
     *
     * @param int      $outOfTaxes
     * @param int|null $valueAddedTaxPercent
     */
    public function __construct(int $outOfTaxes, ?int $valueAddedTaxPercent = null)
    {
        $this->outOfTaxes = $outOfTaxes;
        $this->valueAddedTaxPercent = $valueAddedTaxPercent;
    }

    /**
     * @return int
     */
    public function getOutOfTaxes(): int
    {
        return $this->outOfTaxes;
    }

    /**
     * @return int
     */
    public function getValueAddedTax(): int
    {
        $this->valueAddedTax = $this->outOfTaxes * ($this->valueAddedTaxPercent / 100);

        return $this->valueAddedTax;
    }

    /**
     * @return int
     */
    public function getTaxIncluded(): int
    {
        $this->taxIncluded = $this->outOfTaxes + $this->getValueAddedTax();

        return $this->taxIncluded;
    }

    /**
     * @return int[null
     */
    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    /**
     * @param int $discount
     */
    public function setDiscount(int $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return int|null
     */
    public function getDiscountPercent(): ?int
    {
        return $this->discountPercent;
    }

    /**
     * @param int $discountPercent
     */
    public function setDiscountPercent(int $discountPercent): void
    {
        $this->discountPercent = $discountPercent;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getDiscountedOutOfTaxes(): int
    {
        if (null === $this->valueAddedTaxPercent) {
            throw new Exception(
                sprintf(
                    '%s is not available for Amount with VAT, use %s instead',
                    __METHOD__,
                    'getDiscountedAmount'
                )
            );
        }

        $this->discountedOutOfTaxes = $this->outOfTaxes - $this->getDiscountInValue();

        return $this->discountedOutOfTaxes;
    }

    /**
     * @return bool
     */
    public function isApplicableVAT()
    {
        return !(null === $this->valueAddedTaxPercent);
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        $this->amount = $this->outOfTaxes;

        return $this->amount;
    }

    /**
     * @return int
     */
    public function getDiscountedAmount(): int
    {
        $this->discountedAmount = $this->getAmount() - $this->discount;

        return $this->discountedAmount;
    }

    /**
     * @return float|int
     */
    public function getDiscountInValue()
    {
        if (null !== $this->discount) {
            return $this->discount;
        }

        if (null !== $this->discountPercent) {
            return $this->outOfTaxes * ($this->discountPercent / 100 / 100);
        }

        return 0;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getPartsWithTaxes(): array
    {
        return [
            'outOfTaxes' => $this->outOfTaxes,
            'valueAddedTax' => $this->getValueAddedTax(),
            'taxIncluded' => $this->getTaxIncluded(),
            'discount' => $this->getDiscount(),
            'discountPercent' => $this->getDiscountPercent(),
            'discountedOutOfTaxes' => $this->getDiscountedOutOfTaxes(),
        ];
    }

    /**
     * @return array
     */
    public function getPartsWithoutTaxes(): array
    {
        return [
            'amount' => $this->getAmount(),
            'discount' => $this->getDiscount(),
            'discountPercent' => $this->getDiscountPercent(),
            'discountedAmount' => $this->getDiscountedAmount(),
        ];
    }
}
