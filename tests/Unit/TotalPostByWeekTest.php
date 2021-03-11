<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Services\Post\Collection\PostCollection;
use App\Services\Post\Aggregates\TotalPostByWeek;
use PHPUnit\Framework\TestCase;

class TotalPostByWeekTest extends TestCase
{
    /**
     * @var PostCollection
     */
    private PostCollection $postCollection;

    /**
     * @var TotalPostByWeek
     */
    private TotalPostByWeek $calcByWeek;

    /**
     * Initial values
     */
    protected function setUp(): void
    {
        // create new instance of aggregator
        $this->calcByWeek = new TotalPostByWeek();

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
            '2021-07' => 3,
            '2021-02' => 1,
            '2021-04' => 1,
            '2020-53' => 4,
        ];

        $this->assertSame($expectedOutput, $this->calcByWeek->apply($this->postCollection));
    }

    /**
     * @return array
     */
    public function getProvidedData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/../static/posts.json'), true);
    }
}