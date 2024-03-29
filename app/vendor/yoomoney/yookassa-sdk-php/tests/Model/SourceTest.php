<?php

namespace Tests\YooKassa\Model;

use PHPUnit\Framework\TestCase;
use YooKassa\Helpers\Random;
use YooKassa\Model\AmountInterface;
use YooKassa\Model\CurrencyCode;
use YooKassa\Model\MonetaryAmount;
use YooKassa\Model\Source;

class SourceTest extends TestCase
{
    /**
     * @return Source
     */
    protected function getTestInstance()
    {
        return new Source();
    }

    /**
     * @dataProvider validDataProvider
     *
     * @param array $value
     */
    public function testFromArray($value)
    {
        $instance = $this->getTestInstance();

        self::assertNull($instance->getAmount());
        self::assertNull($instance->getPlatformFeeAmount());
        self::assertNull($instance->getAccountId());
        self::assertNull($instance->amount);
        self::assertNull($instance->platform_fee_amount);
        self::assertNull($instance->accountId);
        self::assertFalse($instance->hasAmount());
        self::assertFalse($instance->hasPlatformFeeAmount());

        $instance->fromArray($value);

        self::assertSame($value['account_id'], $instance->getAccountId());
        self::assertSame($value['account_id'], $instance->accountId);
        self::assertSame($value['amount'], $instance->getAmount()->jsonSerialize());
        self::assertSame($value['amount'], $instance->amount->jsonSerialize());
        self::assertSame($value['platform_fee_amount'], $instance->getPlatformFeeAmount()->jsonSerialize());
        self::assertSame($value['platform_fee_amount'], $instance->platform_fee_amount->jsonSerialize());
        self::assertTrue($instance->hasAmount());
        self::assertTrue($instance->hasPlatformFeeAmount());

        self::assertSame($value, $instance->jsonSerialize());
    }

    /**
     * @dataProvider validDataProvider
     *
     * @param array $value
     */
    public function testGetSetAccountId($value)
    {
        $instance = $this->getTestInstance();

        self::assertNull($instance->getAccountId());
        self::assertNull($instance->accountId);
        $instance->setAccountId($value['account_id']);
        self::assertSame($value['account_id'], $instance->getAccountId());
        self::assertSame($value['account_id'], $instance->accountId);
    }

    /**
     * @dataProvider validDataProvider
     *
     * @param AmountInterface $value
     */
    public function testSetterAccountId($value)
    {
        $instance = $this->getTestInstance();
        $instance->accountId = $value['account_id'];
        self::assertSame($value['account_id'], $instance->getAccountId());
        self::assertSame($value['account_id'], $instance->accountId);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function validDataProvider()
    {
        $result = array();
        for ($i = 0; $i < 10; $i++) {
            $result[] = array(
                'account_id' => (string)Random::int(11111111, 99999999),
                'amount' => array(
                    'value' => sprintf('%.2f', round(Random::float(0.1, 99.99), 2)),
                    'currency' => Random::value(CurrencyCode::getValidValues())
                ),
                'platform_fee_amount' => array(
                    'value' => sprintf('%.2f', round(Random::float(0.1, 99.99), 2)),
                    'currency' => Random::value(CurrencyCode::getValidValues())
                )
            );
        }
        return array($result);
    }

    /**
     * @dataProvider invalidAccountIdProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $value
     */
    public function testGetSetInvalidAccountId($value)
    {
        $this->getTestInstance()->setAccountId($value);
    }

    /**
     * @dataProvider invalidAccountIdProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param $value
     */
    public function testSetterInvalidAccountId($value)
    {
        $this->getTestInstance()->accountId = $value;
    }

    /**
     * @return array
     */
    public function invalidAccountIdProvider()
    {
        return array(
            array(null),
            array(''),
            array(array()),
            array(new \stdClass()),
        );
    }

    /**
     * @dataProvider validAmountDataProvider
     *
     * @param $value
     */
    public function testGetSetAmount($value)
    {
        $instance = $this->getTestInstance();

        self::assertNull($instance->getAmount());
        self::assertNull($instance->amount);
        $instance->setAmount($value);
        self::assertSame($value, $instance->getAmount());
        self::assertSame($value, $instance->amount);
    }

    /**
     * @dataProvider validAmountDataProvider
     *
     * @param AmountInterface $value
     */
    public function testSetterAmount($value)
    {
        $instance = $this->getTestInstance();
        $instance->amount = $value;
        self::assertSame($value, $instance->getAmount());
        self::assertSame($value, $instance->amount);
    }

    /**
     * @dataProvider validAmountDataProvider
     *
     * @param $value
     */
    public function testGetSetPlatformFeeAmount($value)
    {
        $instance = $this->getTestInstance();

        self::assertNull($instance->getPlatformFeeAmount());
        self::assertNull($instance->platform_fee_amount);
        $instance->setPlatformFeeAmount($value);
        self::assertSame($value, $instance->getPlatformFeeAmount());
        self::assertSame($value, $instance->platform_fee_amount);
    }

    /**
     * @dataProvider validAmountDataProvider
     *
     * @param AmountInterface $value
     */
    public function testSetterPlatformFeeAmount($value)
    {
        $instance = $this->getTestInstance();
        $instance->platform_fee_amount = $value;
        self::assertSame($value, $instance->getPlatformFeeAmount());
        self::assertSame($value, $instance->platform_fee_amount);
    }

    /**
     * @return \YooKassa\Model\MonetaryAmount[][]
     * @throws \Exception
     */
    public function validAmountDataProvider()
    {
        return array(
            array(
                new MonetaryAmount(
                    Random::int(1, 100),
                    Random::value(CurrencyCode::getValidValues())
                ),
            ),
            array(
                new MonetaryAmount(),
            ),
        );
    }

    /**
     * @dataProvider invalidAmountDataProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param $value
     */
    public function testSetInvalidAmount($value)
    {
        $this->getTestInstance()->setAmount($value);
    }

    /**
     * @dataProvider invalidAmountDataProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param $value
     */
    public function testSetterInvalidAmount($value)
    {
        $this->getTestInstance()->amount = $value;
    }

    /**
     * @dataProvider invalidAmountDataProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param $value
     */
    public function testSetInvalidPlatformFeeAmount($value)
    {
        $this->getTestInstance()->setPlatformFeeAmount($value);
    }

    /**
     * @dataProvider invalidAmountDataProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param $value
     */
    public function testSetterInvalidPlatformFeeAmount($value)
    {
        $this->getTestInstance()->platform_fee_amount = $value;
    }

    /**
     * @return array
     */
    public function invalidAmountDataProvider()
    {
        return array(
            array(null),
            array(''),
            array(1.0),
            array(1),
            array(true),
            array(false),
            array(new \stdClass()),
        );
    }
}