<?php

declare(strict_types=1);

namespace JeroenG\Autowire\Tests\Unit;

use JeroenG\Autowire\Crawler;
use JeroenG\Autowire\Tests\Support\Subject\Contracts\GoodbyeInterface;
use JeroenG\Autowire\Tests\Support\Subject\Contracts\HelloInterface;
use JeroenG\Autowire\Tests\Support\Subject\Domain\Greeting\ClassGreeting;
use JeroenG\Autowire\Tests\Support\Subject\Domain\Greeting\ConfigGreeting;
use JeroenG\Autowire\Tests\Support\Subject\Domain\Greeting\TextGreeting;
use JeroenG\Autowire\Tests\Support\Subject\Domain\MarsClass;
use JeroenG\Autowire\Tests\Support\Subject\Domain\WorldClass;
use JeroenG\Autowire\Tests\Support\SubjectDirectory;
use PHPUnit\Framework\TestCase;

final class CrawlerTest extends TestCase
{
    public function test_it_can_construct_list_of_files(): void
    {
        $crawler = Crawler::in([SubjectDirectory::ALL]);

        $expected = [
            GoodbyeInterface::class,
            HelloInterface::class,
            ClassGreeting::class,
            ConfigGreeting::class,
            TextGreeting::class,
            MarsClass::class,
            WorldClass::class,
        ];

        self::assertEquals($expected, $crawler->classNames());
    }

    public function test_it_can_filter(): void
    {
        $crawler = Crawler::in([SubjectDirectory::ALL])
            ->filter(fn(string $class) => !str_contains($class, 'Greeting'));

        $expected = [
            GoodbyeInterface::class,
            HelloInterface::class,
            MarsClass::class,
            WorldClass::class,
        ];

        self::assertEquals($expected, array_values($crawler->classNames()));
    }
}
