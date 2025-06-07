<?php

namespace Tests\Unit\Infra\Enum;

use App\Infra\Enum\StatusActiveInactiveEnum;
use Tests\UnitTestCase;

class StatusActiveInactiveEnumUnitTest extends UnitTestCase
{
    public function testEnum()
    {
        $this->assertEquals(1, StatusActiveInactiveEnum::Active->value);
        $this->assertEquals(0, StatusActiveInactiveEnum::Inactive->value);
    }

    public function testGetValues()
    {
        $values = StatusActiveInactiveEnum::getValues();

        $this->assertIsArray($values);
        $this->assertEquals([
            StatusActiveInactiveEnum::Active->value,
            StatusActiveInactiveEnum::Inactive->value,
        ], StatusActiveInactiveEnum::getValues());
    }

    public function testGetForValidation()
    {
        $this->assertEquals('1,0', StatusActiveInactiveEnum::getForValidation());
    }

    public function testRawQueryCase()
    {
        $expectedWithAlias = "CASE status
                    WHEN 1 THEN 'Ativo'
                    WHEN 0 THEN 'Inativo'
                    ELSE 'Desconhecido'
                END as status_label";

        $expectedWithoutAlias = "CASE status
                    WHEN 1 THEN 'Ativo'
                    WHEN 0 THEN 'Inativo'
                    ELSE 'Desconhecido'
                END";

        $this->assertEquals(
            $expectedWithAlias,
            StatusActiveInactiveEnum::rawQueryCase('status', true)
        );

        $this->assertEquals(
            $expectedWithoutAlias,
            StatusActiveInactiveEnum::rawQueryCase('status', false)
        );
    }
}
