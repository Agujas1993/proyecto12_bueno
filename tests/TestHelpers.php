<?php

namespace Tests;

use App\Profession;

trait TestHelpers
{
    public function assertDatabaseEmpty($table, $connection = null)
    {
        $total = $this->getConnection($connection)->table($table)->count();
        $this->assertSame(0, $total, sprintf(
            "Failed asserting the table [%s] is empty. %s %s found", $table,$total, str_plural('row', $total)
        ));
    }
    public function withData(array $custom = [])
    {
        $this->profession = factory(Profession::class)->create();

        return array_merge($this->defaultData(), $custom);
    }

    protected function defaultData()
    {
        return $this->defaultData;
    }
}