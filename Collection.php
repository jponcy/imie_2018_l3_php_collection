<?php

/**
 * This class provides some stuff to use functional method on array with easy syntax.
 */
class Collection {

    /** Easy way to build a collection. */
    public static function build(... $elements): Collection {
        return new Collection;
    }

    /** Stores the given element into collection. */
    public function add($element): Collection {
        return $this;
    }

    /** Gets the nth ($i) element from store. */
    public function get(int $index) {
        return null;
    }

    /** Gets the number of stored element. */
    public function size(): int {
        return 0;
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
        return $this;
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
        return $this;
    }

    /**
     * The array_search method (upgraded) with object syntax.
     *
     * @param closure $function The callback should take at least the first parameter, all provided (in same order) are:
     * - the loop element
     * - the loop index
     * - the complete collection
     */
    public function find(closure $function): Collection {
        return $this;
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
    public function reduce(closure $function): Collection {
        return $this;
    }
}
