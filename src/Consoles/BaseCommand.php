<?php

namespace Shipu\Tie\Consoles;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Facades\Config;
use Shipu\Tie\Support\Stub;

abstract class BaseCommand extends Command
{
    /**
     * Filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Package Location.
     *
     * @var string
     */
    protected $path;

    /**
     * Package Name.
     *
     * @var string
     */
    protected $package;

    /**
     * Vendor Name.
     *
     * @var Filesystem
     */
    protected $vendor;

    /**
     * Namespace for stub class.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Create a new command instance.
     * @param File $filesystem
     * @param Repository $config
     */
    public function __construct(File $filesystem, Repository $config)
    {
        $this->filesystem = $filesystem;
        $this->config     = $config;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->beforeHandle();
        $this->requiredTaskAndInputs();
        $this->afterHandle();
    }

    public function beforeHandle()
    {
        // TODO: Overwrite this method if you need to do something before handle method calling
    }

    /**
     * Modify or Getting inputs
     */
    protected function requiredTaskAndInputs()
    {
        $this->vendor  = $this->setVendor();
        $this->package = $this->setPackage();

        if (blank($this->vendor)) {
            $this->vendor = !blank($this->config->get('tie.vendor')) ? $this->config->get('tie.vendor') : snake_case(strtolower($this->ask('Vendor Name?')));
        } else {
            $vendor = explode('/', $this->vendor);
            if (isset($vendor[1])) {
                $this->package = $vendor[1];
                $this->vendor  = $vendor[0];
            }
        }

        if (blank($this->package)) {
            $this->package = strtolower($this->ask('Your Package Name?'));
        }

        $this->package = $this->package;
        $this->makeBaseDirectory();
        $this->configureNamespace();
    }

    abstract protected function setVendor();

    abstract protected function setPackage();

    /**
     * Make package development base directory
     */
    public function makeBaseDirectory()
    {
        $this->path = $this->config->get('tie.root') . '/' . $this->vendor . '/' . $this->package;

        $this->makeDir($this->path);
    }

    /**
     * Make directory.
     *
     * @param string $directory
     *
     * @return void
     */
    protected function makeDir($directory)
    {
        if (!$this->filesystem->isDirectory($directory)) {
            $this->filesystem->makeDirectory($directory, 0777, true);
        }
    }

    /**
     * Making package namespace
     */
    public function configureNamespace()
    {
        $this->namespace = (!blank($this->config->get('tie.rootNamespace')) ? $this->config->get('tie.rootNamespace') : studly_case($this->vendor)) . '\\' . studly_case($this->package) . '\\';
    }

    abstract protected function afterHandle();

    /**
     * Generate stub file and save specific location
     *
     * @param $location
     * @param $fileFullName
     * @param $configuration
     */
    public function generateStubFile($location, $fileFullName, $configuration)
    {
        $fileName = str_replace([ 'VENDOR_NAME', 'VENDOR_NAME_LOWER', 'PACKAGE_NAME', 'PACKAGE_NAME_LOWER' ], [
            studly_case($this->vendor),
            strtolower($this->vendor),
            studly_case($this->package),
            strtolower($this->package),
        ], $this->filesystem->name($fileFullName));

        $fileExtension = $this->filesystem->extension($fileFullName);
        if (blank($fileExtension)) {
            $fileExtension = data_get($configuration, 'extension', 'php');
        }

        $suffix    = data_get($configuration, 'suffix', '');
        if(substr_compare($fileName, $suffix, -strlen($suffix))) {
            $fileName .= $suffix;
        }

        $prefix    = data_get($configuration, 'prefix', '');
        if(substr_compare($fileName, $prefix, 0, strlen($prefix))) {
            $fileName = $prefix . $fileName;
        }

        $namespace = data_get($configuration, 'namespace', '');
        $fileName  = $this->fileNameCaseConvention($fileName, $configuration);

        $this->makeDir($location);
        Stub::create(
            $this->findingStub($this->stubKey),
            $this->replaceStubString($fileName, $namespace)
        )->save($location, $fileName . '.' . $fileExtension);
    }

    /**
     * File name case convention
     *
     * @param $name
     * @param string $case
     * @return string
     */
    public function fileNameCaseConvention($name, $case = 'studly')
    {
        if (is_array($case)) {
            $case = data_get($case, 'case', 'studly');
        }

        switch ($case) {
            case 'studly':
                return studly_case($name);
            case 'lower':
                return strtolower($name);
            case 'upper':
                return strtoupper($name);
            case 'snake':
                return snake_case($name);
            case 'title':
                return title_case($name);
            case 'camel':
                return camel_case($name);
            case 'kebab':
                return kebab_case($name);
        }

        return $name;
    }

    /**
     * Finding multi location stub
     *
     * @param $stubName
     * @return string
     */
    public function findingStub($stubName)
    {
        $stubRoots = $this->config->get('tie.stubs.path');
        foreach ($stubRoots as $stubRoot) {
            $stub = $stubRoot . '/' . $stubName . '.stub';
            if ($this->filesystem->exists($stub)) {
                return $stub;
            }
        }

        return '';
    }

    /**
     * Replace dummy name to real name
     *
     * @param $className
     * @param $namespace
     * @return array
     */
    protected function replaceStubString($className, $namespace)
    {
        return array_merge([
            'VENDOR_NAME_LOWER'  => strtolower($this->vendor),
            'VENDOR_NAME'        => studly_case($this->vendor),
            'PACKAGE_NAME_LOWER' => strtolower($this->package),
            'PACKAGE_NAME'       => studly_case($this->package),
            'DummyClass'         => studly_case($className),
            'DummyModel'         => str_replace(['Resource'], [''], studly_case($className)),
            'DummyTarget'        => strtolower($className),
            'DummyNamespace'     => empty($namespace) ? rtrim($this->namespace, '\\') : $this->namespace . $namespace,
            'DummyRootNamespace' => $this->laravel->getNamespace(),
        ], $this->config->get('tie.stubs.replace'));
    }

    /**
     * Package namespace adding in composer
     *
     * @param $namespace
     * @param $path
     * @param string $output
     * @internal param $key
     */
    public function addingNamespaceInComposer($namespace, $path, $output = 'composer.json')
    {
        $file = base_path('composer.json');
        $data = json_decode($this->filesystem->get($file), true);

        $rootStub = $this->config->get('tie.stubs.root');
        if(is_array($rootStub)) {
            $rootStub = data_get($this->config->get($rootStub), 'path',  '');
        }

        $path = str_replace(base_path().'/', '', $path) . '/' . $rootStub;

        $data["autoload"]["psr-4"] = array_merge($data["autoload"]["psr-4"], [ $namespace => $path ]);
        $this->filesystem->put(base_path($output), json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}
