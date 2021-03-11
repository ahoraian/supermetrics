<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Services\Post\Collection\PostCollection;
use App\Services\Post\Aggregates\LongestPostByCharLenPerMonth;
use PHPUnit\Framework\TestCase;

class LongestPostByCharLenPerMonthTest extends TestCase
{
    /**
     * @var PostCollection
     */
    private PostCollection $postCollection;

    /**
     * @var LongestPostByCharLenPerMonth
     */
    private LongestPostByCharLenPerMonth $calcLongestPost;

    /**
     * Initial values
     */
    protected function setUp(): void
    {
        // create new instance of aggregator
        $this->calcLongestPost = new LongestPostByCharLenPerMonth();

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
            '2021-02' => 140,
            '2021-01' => 113,
            '2020-12' => 278
        ];
        $this->assertSame($expectedOutput, $this->calcLongestPost->apply($this->postCollection));
    }

    /**
     * @return array
     */
    public function getProvidedData(): array
    {
        return json_decode(file_get_contents(__DIR__ . '/../static/posts.json'), true);
    }
}