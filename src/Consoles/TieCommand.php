<?php

namespace Shipu\Tie\Consoles;

class TieCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:create {vendor?} {packageName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Package Boilerplate';

    /**
     * Config stub key
     *
     * @var string
     */
    protected $stubKey;

    /**
     * Set vendor name
     *
     * @return array|string
     */
    protected function setVendor()
    {
        return $this->argument('vendor');
    }

    /**
     * Set package name
     *
     * @return array|string
     */
    protected function setPackage()
    {
        return $this->argument('packageName');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function afterHandle()
    {
        $this->makeDefaultPackageStructure();
        $this->addingNamespaceInComposer($this->namespace, $this->path);
        $this->endingTask();
    }

    /**
     * Default configuration package structure
     */
    public function makeDefaultPackageStructure()
    {
        $default = $this->config->get('tie.stubs.default');
        if (!blank($default)) {
            foreach ($default as $stubKey) {
                $this->stubKey = $stubKey;
                $configuration = $this->config->get('tie.stubs.structure.' . $stubKey);
                if (is_array($configuration)) {
                    $this->createStubFiles($configuration);
                } else {
                    $this->makeDir($this->path . '/' . $configuration);
                }
            }
        }
    }

    /**
     * Create default configuration folder and files
     *
     * @param $configuration
     */
    public function createStubFiles($configuration)
    {
        $stubPathLocation = $this->path . '/' . data_get($configuration, 'path', '');
        if (isset($configuration['files'])) {
            foreach ($configuration['files'] as $file) {
                $this->generateStubFile($stubPathLocation, $file, $configuration);
            }
        }
    }

    /**
     * After successfully creating task
     */
    public function endingTask()
    {
        $this->alert("Successfully Create ".$this->vendor.'/'.$this->package." Package");
        $this->comment(str_repeat('*', 65));
        $this->comment('  Package: '.$this->package);
        $this->output->writeln('');
        $this->line('  Namespace: '.htmlentities($this->namespace));
        $this->output->writeln('');
        $this->comment('  Path Location: '.$this->path);
        $this->comment(str_repeat('*', 65));
        $this->output->writeln('');
        $this->alert("Run: composer dump-autoload");
    }
}
