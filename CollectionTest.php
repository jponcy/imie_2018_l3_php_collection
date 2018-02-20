<?php

declare(strict_types=1);

require('Collection.php');

use PHPUnit\Framework\TestCase;

final class CollectionTest extends TestCase {
    /** @param Collection $cs Collection without items. */
    private $cs;
    /** @param Collection $cp Collection with items (initialized with parameter). */
    private $cp;

    public function setUp() {
        $this->cs = new Collection();
        $this->cp = new Collection([1, 2, 3]);
    }

    public function testConstructAndSize() {
        $this->assertEquals(0, $this->cs->size(), 'Problem on default constructor.');
        $this->assertEquals(3, $this->cp->size(), 'Problem on constructor with array.');
    }

    public function testBuild() {
        $this->assertEquals(0, Collection::build()->size(), 'Problem on empty build.');
        $this->assertEquals(3, Collection::build(1, 2, 3)->size(), 'Problem on build with array.');
    }

    public function testMapSquare() {
        $square = $this->cp->map(function ($elt) {
            return $elt ** 2;
        });

        $this->assertEquals(3, $square->size());
        $this->assertEquals(1, $square->get(0));
        $this->assertEquals(4, $square->get(1));
        $this->assertEquals(9, $square->get(2));
    }

    public function testMapIndex() {
        $index = $this->cp->map(function ($elt, $i) {
            return $i;
        });

        $this->assertEquals(3, $index->size());
        $this->assertEquals(0, $index->get(0));
        $this->assertEquals(1, $index->get(1));
        $this->assertEquals(2, $index->get(2));
    }

    public function testMapList() {
        $list = $this->cp->map(function ($elt, $i, $list) {
            return $list;
        });

        $this->assertTrue($list instanceof Collection);
        $this->assertEquals(3, $list->size());

        $list->forEach(function ($l) use($list) {
            // Test to get copy & not origin => not mutable.
            $this->assertTrue($l instanceof Collection);
            $this->assertFalse($list === $l);

            // Test same size.
            $this->assertEquals(3, $l->size());

            // Test same final values.
            $this->assertEquals(1, $l->get(0));
            $this->assertEquals(2, $l->get(1));
            $this->assertEquals(3, $l->get(2));
        });
    }

    public function testFilter() {
        $filter = $this->cp->filter(function ($elt, $i) {
            return $i % 2 === 1;
        });

        $this->assertEquals(1, $filter->size());
        $this->assertEquals(2, $filter->get(0));

        $filter = $this->cp->filter(function ($elt, $i) {
            return $elt >= 2;
        });

        $this->assertEquals(2, $filter->size());
        $this->assertEquals(2, $filter->get(0));
        $this->assertEquals(3, $filter->get(1));
    }

    public function testFind() {
        $this->assertEquals(2, $this->cp->find(function ($elt, $i) {
            return $i >= 1;
        }));

        $this->assertEquals(3, $this->cp->find(function ($elt, $i) {
            return $elt > 2;
        }));
    }

    public function testReduce() {
        $this->assertEquals(6, $this->cp->reduce(function ($elt, $acc) {
            return $elt + $acc;
        }));

        $this->assertEquals(6, $this->cp->reduce(function ($elt, $acc) {
            return $elt * $acc;
        }));
    }

    public function testFact() {
        $fact = function($nb) {
            $c = new Collection;

            for ($i = $nb; $nb > 0; -- $nb) {
                $c->add($nb);
            }

            return $c->reduce(function ($elt, $acc) {
                return ($elt ?? 1) * $acc;
            });
        };

        $this->assertEquals(1, $fact(0));
        $this->assertEquals(1, $fact(1));
        $this->assertEquals(10, $fact(3628800));
    }
}
