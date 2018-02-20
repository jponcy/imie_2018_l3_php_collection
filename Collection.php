<?php

declare(strict_types=1);

/**
 * This class provides some stuff to use functional method on array with easy syntax.
 */
class Collection {
    /** * @param array|mixed[] $elements The stored elements. */
    private $elements = [];

    /** Easy way to build a collection. */
    public static function build(... $elements): Collection {
        /*
        $result = new Collection;

        foreach ($elements as $elt) {
            $result->add($elt);
        }

        return $result;
        */
        return new Collection($elements);
    }

    /** Default Constructor. */
    public function __construct(array $list = null) {
        if ($list !== null) {
            $this->elements = $list;
        }
    }

    /** Stores the given element into collection. */
    public function add($element): Collection {
        $this->elements[] = $element;

        return $this;
    }

    /** Gets the nth ($i) element from store. */
    public function get(int $index) {
        return $this->elements[$index] ?? null;
    }

    /** Gets the number of stored element. */
    public function size(): int {
        return count($this->elements);
    }

    /**
     * The array_walk method (upgraded) with object syntax.
     *
     * @param closure $function The callback should take at least the first parameter, all provided (in same order) are:
     * - the loop element
     * - the loop index
     * - the complete collection
     */
    public function forEach(closure $function): Collection {
        /*
        $i = 0;
        $list = $this;

        array_walk($this->elements, function ($elt) use($function, $list) {
            $function($elt, $i ++, $list);
        });
        */

        // -----

        foreach ($this->elements as $i => $elt) {
            $function($elt, $i, $this);
        }

        return $this;
    }

    /**
     * The array_map method (upgraded) with object syntax.
     *
     * @param closure $function The callback should take at least the first parameter, all provided (in same order) are:
     * - the loop element
     * - the loop index
     * - the complete collection
     */
    public function map(closure $function): Collection {
        /*
        // With foreach.
        $result = new Collection;

        foreach ($this->elements as $i => $elt) {
            $result->add($function($elt, $i, $this));
        }

        return $result;
        */

        // With our forEach.
        $result = new Collection;

        $this->forEach(function ($elt, $i, $list) use($function, $result) {
            $result->add($function($elt, $i, $list));
        });

        return $result;

        /*
        // With array_map.
        $i = 0;
        $list = $this;

        return array_map(function ($elt) use($i, $function, $list) {
            return $function($elt, $i ++, $list);
        });
        */
    }

    /**
     * The array_filter method (upgraded) with object syntax.
     *
     * @param closure $function The callback should take at least the first parameter, all provided (in same order) are:
     * - the loop element
     * - the loop index
     * - the complete collection
     */
    public function filter(closure $function): Collection {
        $result = new Collection;

        $this->forEach(function ($elt, $i, $list) use($function, $result) {
            if ($function($elt, $i, $list)) {
                $result->add($elt);
            }
        });

        return $result;
    }

    /**
     * The array_search method (upgraded) with object syntax.
     *
     * @param closure $function The callback should take at least the first parameter, all provided (in same order) are:
     * - the loop element
     * - the loop index
     * - the complete collection
     */
    public function find(closure $function) {
        foreach ($this->elements as $i => $elt) {
            if ($function($elt, $i, $this)) {
                return $elt;
            }
        }

        return null;
    }

    /**
     * The array_reduce method (upgraded) with object syntax.
     *
     * @param closure $function The callback should take at least the two first parameters, all provided (in same order) are:
     * - the loop element
     * - the accumulator element
     * - the loop index
     * - the complete collection
     */
    public function reduce(closure $function, $default = null) {
        if ($this->size() === 0) {
            return $default;
        }

        if ($default === null) {
            $result = $this->get(0);
            $start = 1;
        } else {
            $result = $default;
            $start = 0;
        }

        for ($i = $start; $i < $this->size(); ++ $i) {
            $result = $function($this->get($i), $result, $i, $this);
        }

        return $result;
    }
}
