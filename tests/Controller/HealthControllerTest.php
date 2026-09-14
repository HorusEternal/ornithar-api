<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HealthControllerTest extends WebTestCase
{
    public function testHealthEndpointReturnsOkJson(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/health');

        self::assertResponseStatusCodeSame(200);
        self::assertResponseHeaderSame('content-type', 'application/json');

        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertJson($content);
        self::assertSame(['status' => 'ok'], json_decode($content, true, 512, JSON_THROW_ON_ERROR));
    }
}
