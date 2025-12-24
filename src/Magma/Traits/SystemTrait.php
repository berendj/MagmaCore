<?php

declare(strict_types=1);

namespace Magma\Traits;

use Magma\Base\Exception\BasLogicException;
use Magma\GlobalManager\GlobalManager;
use Magma\Session\SessionManager;


trait SystemTrait
{
    protected string $systemName = 'Magma';

    public static function sessionInit(bool $useSessionGlobal = false)
    {
        $session = SessionManager::initialize();
        if (!$session)
        {
            throw new BasLogicException('Please enable session within your session.yaml configuration file.');
        } else if ($useSessionGlobal === true) {
            GlobalManager::set('global_session', $session);
        } else {
            return $session;
        }
    }
}