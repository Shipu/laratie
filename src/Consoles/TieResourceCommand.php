<?php

namespace Shipu\Tie\Consoles;

class TieResourceCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:file {vendor}
                            {--controller=}
                            {--command=}
                            {--events=}
                            {--facades=}
                            {--config=}
                            {--migration=}
                            {--job=}
                            {--provider=}
                            {--routes=}
                            {--middleware=}
                            {--class=}
                            {--exceptions=}
                            {--key=}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Package Boilerplate Resource';

    /**
     * File name
     *
     * @var string
     */
    protected $resourceName;

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
     * @return string
     */
    protected function setPackage()
    {
        return '';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function afterHandle()
    {
        $this->createStubs();
        $this->alert('Done Boss');
    }
    /**
     * Eligible stub config
     */
    public function createStubs()
    {
        foreach ($this->options() as $stubKey => $fileName) {
            if(!blank($fileName) && $fileName) {
                $this->resourceName = $fileName;
                $this->stubKey = $stubKey;
                if($stubKey == 'key') {
                    $this->stubKey = $fileName;
                    $this->resourceName = strtolower($this->ask('Enter your file name'));
                }
                $configuration = $this->config->get('tie.stubs.structure.' . $this->stubKey);
                $this->createStubFiles($configuration);
            }
        }
    }

    /**
     * Create Stub File
     *
     * @param $configuration
     */
    public function createStubFiles($configuration)
    {
        $stubPathLocation = $this->path . '/' . data_get($configuration, 'path', $configuration);
        $this->generateStubFile($stubPathLocation, $this->resourceName, $configuration);
        $this->comment("Successfully Create ".$this->resourceName." Resource");
        $this->comment("Path Location ".$stubPathLocation);
        $this->output->writeln('');
    }
}
