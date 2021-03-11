<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Services\Post\Collection\PostCollection;
use App\Services\Post\Aggregates\AverageCharLenPerMonth;
use PHPUnit\Framework\TestCase;

class AverageCharLenPerMonthTest extends TestCase
{
    /**
     * @var PostCollection
     */
    private PostCollection $postCollection;

    /**
     * @var AverageCharLenPerMonth
     */
    private AverageCharLenPerMonth $averageCalculator;

    /**
     *
     * Initial values
     */
    protected function setUp(): void
    {
        // create new instance from aggregator
        $this->averageCalculator = new AverageCharLenPerMonth();

        // add data to posts collection
        $this->postCollection = new PostCollection();
        $this->postCollection->add($this->getProvidedData());
    }

    /**
     * Test average value by static values
     */
    public function testAverageLength(): void
    {
        $expectedOutput = [
            '2021-02' => 282.67,
            '2021-01' => 395.5,
            '2020-12' => 517.75,
        ];

        // calc average
        $this->assertSame($expectedOutput,  $this->averageCalculator->apply($this->postCollection));
    }

    /**
     * @return array
     */
    public function getProvidedData(): array
    {
       return json_decode(file_get_contents(__DIR__ . '/../static/posts.json'), true);
    }
}