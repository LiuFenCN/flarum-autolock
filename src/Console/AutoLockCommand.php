<?php

namespace Acolasi\Autolock\Console;

use Flarum\Console\AbstractCommand;
use Acolasi\Autolock\AutoLocker;

class AutoLockCommand extends AbstractCommand
{
    /**
     * @var AutoLocker
     */
    protected $locker;

    public function __construct(AutoLocker $locker)
    {
        $this->locker = $locker;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('autolock:run')
            ->setDescription('Automatically lock discussions that have been inactive for N days.');
    }

    protected function fire()
    {
        $locked = $this->locker->lockInactiveDiscussions();

        if ($locked > 0) {
            $this->info("AutoLock: Locked {$locked} inactive discussion(s).");
        } else {
            $this->info('AutoLock: No discussions needed locking.');
        }

        return 0;
    }
}
