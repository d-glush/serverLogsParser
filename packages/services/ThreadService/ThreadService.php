<?php

namespace services\ThreadService;

class ThreadService {
    private int $threadsNum = 0;
    private array $threadsCommands = [];
    private array $threadsProcPipes = [];
    private array $threadsProc = [];
    private array $descriptorspec = [
        0 => ["pipe", "r"],
        1 => ["pipe", "w"],
        2 => ["pipe", "w"]
    ];

    public function __construct($threadsNum)
    {
        $this->threadsNum = $threadsNum;
    }

    public function addCommandThread(string $command) {
        $this->threadsCommands[$this->threadsNum] = $command;
        $this->threadsNum++;
    }

    public function startThreads(): void
    {
        foreach ($this->threadsCommands as $threadId => $threadCommand) {
            $this->threadsProc[$threadId] = proc_open(
                $threadCommand,
                $this->descriptorspec,
                $this->threadsProcPipes[$threadId],
            );
        }
    }

    public function isAllThreadsDone(): bool {
        foreach ($this->threadsProc as $threadProc) {
            if (!proc_get_status($threadProc)['running']) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array<string>
     */
    public function getThreadsOutput(): array {
        $threadsOutputs = [];
        foreach ($this->threadsProc as $threadId => $threadProc) {
            $threadsOutputs[$threadId] = stream_get_contents($this->threadsProcPipes[$threadId][1]);
        }
        return $threadsOutputs;
    }
}