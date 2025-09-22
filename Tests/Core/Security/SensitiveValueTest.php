<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests\Core\Security;

use HeyPay\Bundle\PayBundle\Core\Security\SensitiveValue;
use PHPUnit\Framework\TestCase;

class SensitiveValueTest extends TestCase
{
    public function testShouldBeFinal(): void
    {
        $rc = new \ReflectionClass(SensitiveValue::class);

        static::assertTrue($rc->isFinal());
    }

    public function testShouldImplementSerializableInterface(): void
    {
        $rc = new \ReflectionClass(SensitiveValue::class);

        static::assertTrue($rc->implementsInterface(\Serializable::class));
    }

    public function testShouldAllowGetValueSetInConstructorAndErase(): void
    {
        $expectedValue = 'cardNumber';

        $sensitiveValue = new SensitiveValue($expectedValue);

        static::assertSame($expectedValue, $sensitiveValue->get());
        static::assertNull($sensitiveValue->get());
    }

    public function testShouldAllowPeekValueSetInConstructorAndNotErase(): void
    {
        $expectedValue = 'cardNumber';

        $sensitiveValue = new SensitiveValue($expectedValue);

        static::assertSame($expectedValue, $sensitiveValue->peek());
        static::assertSame($expectedValue, $sensitiveValue->peek());
    }

    public function testShouldAllowEraseValue(): void
    {
        $expectedValue = 'cardNumber';

        $sensitiveValue = new SensitiveValue($expectedValue);

        static::assertSame($expectedValue, $sensitiveValue->get());

        $sensitiveValue->erase();

        static::assertNull($sensitiveValue->get());
    }

    public function testShouldNotSerializeValue(): void
    {
        $sensitiveValue = new SensitiveValue('cardNumber');

        $serializedValue = serialize($sensitiveValue);

        // the object will be unserialized anyway, make sure it's empty
        static::assertSame('O:52:"HeyPay\Bundle\PayBundle\Core\Security\SensitiveValue":0:{}', $serializedValue);
        static::assertNull(unserialize($serializedValue)->peek());
    }

    public function testShouldReturnEmptyStringOnToString(): void
    {
        $sensitiveValue = new SensitiveValue('cardNumber');

        static::assertSame('', (string) $sensitiveValue);
    }

    /**
     * @throws \JsonException
     */
    public function testShouldNotExposeValueWhileEncodingToJson(): void
    {
        $sensitiveValue = new SensitiveValue('cardNumber');

        static::assertSame('null', json_encode($sensitiveValue, \JSON_THROW_ON_ERROR));
    }
}
