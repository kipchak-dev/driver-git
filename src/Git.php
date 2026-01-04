<?php

namespace Kipchak\Driver\Git;

use Kipchak\Core\Interfaces;
use Psr\Container\ContainerInterface;
use Kipchak\Driver\Config\Config;
use CzProject\GitPhp\Git as CzGit;
use CzProject\GitPhp\GitRepository;

class Git implements Interfaces\Driver
{
    protected static ContainerInterface $container;

    public static function initialise(ContainerInterface $container, ?string $configFileName = null): void
    {
        self::$container = $container;
        self::set($configFileName);
    }

    public static function set(?string $configFileName = null): void
    {
        $configFileName = $configFileName ?? 'kipchak.git';
        if (isset(Config::get($configFileName)['settings']) && Config::get($configFileName)['repositories']) {
            $clonePath = Config::get($configFileName)['settings']['clone_dir'];
            $repositories = Config::get($configFileName)['repositories'];
            foreach($repositories as $name => $connectionDetails) {
                self::$container->set('drivers.git.' . $name, function (ContainerInterface $c) use ($name, $connectionDetails, $clonePath): GitRepository {
                    $cloneDir = $clonePath . '/' . $name;
                    $git = new CzGit();
                    if (is_dir($cloneDir) && is_dir($cloneDir . '/.git')) {
                        // Repo already cloned. Open and return it.
                        return $git->open($cloneDir);
                    }
                    // Clone the repo.
                    $repo = $git->cloneRepository('https://' .
                        $connectionDetails['username'] . ':' . $connectionDetails['password'] .
                        '@' . $connectionDetails['origin'], $cloneDir);
                    $repo->checkout('master');

                    return $repo;
                });
            }
        }
    }

    public static function get(?string $configKey = null): GitRepository
    {
        return self::$container->get('drivers.git.' . $configKey ?? 'default');
    }

}