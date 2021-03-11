<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Services\Post\Collection\PostCollection;
use App\Services\Post\Aggregates\AveragePostCountPerUserPerMonth;
use PHPUnit\Framework\TestCase;

class AveragePostCountPerUserPerMonthTest extends TestCase
{
    /**
     * @var PostCollection
     */
    private PostCollection $postCollection;

    /**
     * @var AveragePostCountPerUserPerMonth
     */
    private AveragePostCountPerUserPerMonth $averageCalculator;

    /**
     * Initial values
     */
    protected function setUp(): void
    {
        // create new instance of aggregator
        $this->averageCalculator = new AveragePostCountPerUserPerMonth();

        // add data to posts collection
        $this->postCollection = new PostCollection();
        $this->postCollection->add($this->getProvidedData());
    }

    /**
     * Test average value by static values
     */
    public function testAverage()
    {
        $expectedOutput = [
            '2021-02' => 1.0,
            '2021-01' => 1.0,
            '2020-12' => 1.33
        ];

        $this->assertSame($expectedOutput, $this->averageCalculator->apply($this->postCollection));
    }

    /**
     * @return array
     */
    public function getProvidedData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/../static/posts.json'), true);
    }
}