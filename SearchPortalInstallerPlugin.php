<?php
namespace SearchPortal\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class SearchPortalInstallerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new SearchPortalInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}