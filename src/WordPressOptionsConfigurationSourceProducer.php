<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e;

use N7e\Configuration\ConfigurationSourceInterface;
use N7e\Configuration\WordPressOptionsConfigurationSource;
use Override;

/**
 * Produces WordPress Options configuration sources.
 */
class WordPressOptionsConfigurationSourceProducer implements ConfigurationSourceProducerInterface
{
    #[Override]
    public function canProduceConfigurationSourceFor(string $url): bool
    {
        $parts = parse_url($url);

        return is_array($parts) && ($parts['scheme'] ?? '') === 'wordpress-options' && array_key_exists('host', $parts);
    }

    #[Override]
    public function produceConfigurationSourceFor(string $url): ConfigurationSourceInterface
    {
        return new WordPressOptionsConfigurationSource((string) parse_url($url, PHP_URL_HOST));
    }
}
