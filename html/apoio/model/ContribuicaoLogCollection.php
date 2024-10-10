<?php
require_once '../model/ContribuicaoLog.php';

class ContribuicaoLogCollection implements IteratorAggregate {
    private array $logs = [];

    public function __construct(array $logs = []) {
        foreach ($logs as $log) {
            $this->add($log);
        }
    }

    public function add(ContribuicaoLog $log) {
        $this->logs[] = $log;
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->logs);
    }
}
