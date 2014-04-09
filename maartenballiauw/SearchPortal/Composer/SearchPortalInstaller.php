<?php
namespace maartenballiauw\SearchPortal\Composer;

use Composer\Composer;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;

class SearchPortalInstaller extends LibraryInstaller
{
    public function __construct(IOInterface $io, Composer $composer)
    {
        parent::__construct($io, $composer, 'searchportal-plugin');
    }

    protected function getInstallPath(PackageInterface $package)
    {
        return 'app/plugins';
    }

    protected function installCode(PackageInterface $package)
    {
        $downloadPath = $this->getInstallPath($package);
        $this->downloadManager->download($package, $downloadPath);

        var_dump($package);
    }

    protected function removeCode(PackageInterface $package)
    {
        $downloadPath = $this->getPackageBasePath($package);
        $this->downloadManager->remove($package, $downloadPath);
    }
}