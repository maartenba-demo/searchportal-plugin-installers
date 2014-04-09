<?php
namespace SearchPortal\Composer;

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

    protected function appendPluginsJson(PackageInterface $package)
    {
        $fileName = 'app/plugins/plugins.json';

        $json = (array)json_decode(file_exists($fileName) ? file_get_contents($fileName) : '[]');
        $json[$package->getPrettyName()] = (object)array(
            'name' => $package->getPrettyName(),
            'class' => $package->getExtra()['class']
        );
        file_put_contents($fileName, json_encode($json));
    }

    protected function removePluginsJson(PackageInterface $package)
    {
        $fileName = 'app/plugins/plugins.json';

        $json = (array)json_decode(file_exists($fileName) ? file_get_contents($fileName) : '[]');
        unset($json[$package->getPrettyName()]);
        file_put_contents($fileName, json_encode($json));
    }

    public function getInstallPath(PackageInterface $package)
    {
        return 'app/plugins/' . $package->getPrettyName();
    }

    protected function installCode(PackageInterface $package)
    {
        $downloadPath = $this->getInstallPath($package);
        $this->downloadManager->download($package, $downloadPath);

        $this->appendPluginsJson($package);
    }

    protected function removeCode(PackageInterface $package)
    {
        $this->removePluginsJson($package);

        $downloadPath = $this->getPackageBasePath($package);
        $this->downloadManager->remove($package, $downloadPath);
    }
}