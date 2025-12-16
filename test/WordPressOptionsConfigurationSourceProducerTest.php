<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(WordPressOptionsConfigurationSourceProducer::class)]
class WordPressOptionsConfigurationSourceProducerTest extends TestCase
{
    use PHPMock;

    private WordPressOptionsConfigurationSourceProducer $producer;

    #[Before]
    public function setUp(): void
    {
        $this->producer = new WordPressOptionsConfigurationSourceProducer();
    }

    #[Test]
    public function shouldHandleWordPressOptionsSources(): void
    {
        $this->assertTrue($this->producer->canProduceConfigurationSourceFor('wordpress-options://option'));

        $this->assertFalse($this->producer->canProduceConfigurationSourceFor('wordpress-options://'));
        $this->assertFalse($this->producer->canProduceConfigurationSourceFor('http://wordpress-options'));
    }

    #[Test]
    public function shouldProduceConfigurationSourceWithDesiredOptions(): void
    {
        $configurationSource = $this->producer->produceConfigurationSourceFor('wordpress-options://option');
        $values = ['key' => 'value'];

        $this->getFunctionMock('N7e\\Configuration', 'get_option')
            ->expects($this->once())
            ->with('option')
            ->willReturn($values);

        $this->assertEquals($values, $configurationSource->load());
    }
}
