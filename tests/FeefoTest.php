<?php

/*
 * This file is part of Feefo.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Tests\Feefo;

class FeefoTest extends AbstractTestCase
{
    public function testFetchReturnsCollection()
    {
        $feedback = $this->app->feefo->fetch();

        $this->assertInstanceOf('Illuminate\Support\Collection', $feedback);
    }

    public function testFetchItemsAreFeefoItem()
    {
        $feedback = $this->app->feefo->fetch();

        $this->assertInstanceOf('BlueBayTravel\Feefo\FeefoItem', $feedback->first());
    }

    public function testFetchWithParams()
    {
        $feedback = $this->app->feefo->fetch(['limit' => 9999, 'since' => 'year']);

        $this->assertInstanceOf('Illuminate\Support\Collection', $feedback);
        $this->assertInstanceOf('BlueBayTravel\Feefo\FeefoItem', $feedback->first());
    }
}
