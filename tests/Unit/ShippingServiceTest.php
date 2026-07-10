<?php

namespace Tests\Unit;

use App\Services\ShippingService;
use Tests\TestCase;

class ShippingServiceTest extends TestCase
{
    private ShippingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ShippingService();
    }

    public function test_get_couriers_returns_all_expected_couriers(): void
    {
        $couriers = $this->service->getCouriers();

        $this->assertCount(6, $couriers);

        $ids = array_column($couriers, 'id');
        $this->assertContains('jne', $ids);
        $this->assertContains('jnt', $ids);
        $this->assertContains('sicepat', $ids);
        $this->assertContains('pos', $ids);
        $this->assertContains('tiki', $ids);
        $this->assertContains('anteraja', $ids);
    }

    public function test_get_couriers_has_required_fields(): void
    {
        $couriers = $this->service->getCouriers();

        foreach ($couriers as $courier) {
            $this->assertArrayHasKey('id', $courier);
            $this->assertArrayHasKey('name', $courier);
            $this->assertArrayHasKey('service', $courier);
            $this->assertArrayHasKey('eta', $courier);
        }
    }

    public function test_get_costs_returns_fallback_array(): void
    {
        $costs = $this->service->getCosts();

        $this->assertIsArray($costs);
        $this->assertArrayHasKey('jne', $costs);
        $this->assertArrayHasKey('jnt', $costs);
        $this->assertEquals(15000, $costs['jne']);
        $this->assertEquals(14000, $costs['jnt']);
        $this->assertEquals(13000, $costs['sicepat']);
    }

    public function test_get_services_returns_service_mapping(): void
    {
        $services = $this->service->getServices();

        $this->assertIsArray($services);
        $this->assertEquals('REG', $services['jne']);
        $this->assertEquals('EZ', $services['jnt']);
        $this->assertEquals('REG', $services['sicepat']);
    }

    public function test_get_shipping_cost_returns_fallback_without_api_key(): void
    {
        $result = $this->service->getShippingCost('jne');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('cost', $result);
        $this->assertArrayHasKey('service', $result);
        $this->assertArrayHasKey('eta', $result);
        $this->assertEquals(15000, $result['cost']);
        $this->assertEquals('REG', $result['service']);
    }

    public function test_get_shipping_cost_returns_fallback_for_unknown_courier(): void
    {
        $result = $this->service->getShippingCost('unknown_courier');

        $this->assertEquals(15000, $result['cost']);
        $this->assertEquals('REG', $result['service']);
    }

    public function test_get_shipping_cost_returns_fallback_without_destination(): void
    {
        $result = $this->service->getShippingCost('jne', null, 1000);

        $this->assertEquals(15000, $result['cost']);
    }

    public function test_get_shipping_cost_different_couriers_return_different_costs(): void
    {
        $jne = $this->service->getShippingCost('jne');
        $jnt = $this->service->getShippingCost('jnt');
        $pos = $this->service->getShippingCost('pos');

        $this->assertNotEquals($jne['cost'], $pos['cost']);
        $this->assertNotEquals($jnt['cost'], $pos['cost']);
    }
}
