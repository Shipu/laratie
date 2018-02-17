<?php

namespace Shipu\Tie\Support;

use Shipu\Tie\Exceptions\FileNotFoundException;

class Stub
{
    /**
     * The base path of stub file.
     *
     * @var null|string
     */
    protected static $basePath = null;

    /**
     * The default folder path of stub file.
     *
     * @var string
     */
    public $defaultStubFolderPath = __DIR__ . '/../Consoles/stubs/';

    /**
     * The stub path.
     *
     * @var string
     */
    protected $path;

    /**
     * The replacements array.
     *
     * @var array
     */
    protected $replaces = [];

    /**
     * The constructor.
     *
     * @param string $path
     * @param array $replaces
     */
    public function __construct($path = [], array $replaces = [])
    {
        $this->path     = $path;
        $this->replaces = $replaces;
    }

    /**
     * Create new self instance.
     *
     * @param string $path
     * @param array $replaces
     *
     * @return self
     */
    public static function create($path, array $replaces = [])
    {
        return new static($path, $replaces);
    }

    /**
     * Save stub to specific path.
     *
     * @param string $path
     * @param string $filename
     *
     * @return bool
     */
    public function save($path, $filename)
    {
        if (!file_exists($path)) {
            $this->makeDirectory($path);
        }

        return file_put_contents($path . '/' . $filename, $this->getContents());
    }

    /**
     * Get stub contents.
     *
     * @return mixed|string
     */
    public function getContents()
    {
        $contents = file_get_contents($this->getPath());

        return str_replace(
            array_keys($this->replaces), array_values($this->replaces), $contents
        );
    }

    /**
     * Get stub path.
     * @return string
     * @throws FileNotFoundException
     */
    public function getPath()
    {
        $path = static::getBasePath() . $this->path;

        if (file_exists($path)) {
            return $path;
        } elseif (file_exists($this->defaultStubFolderPath . $this->path)) {
            return $this->defaultStubFolderPath . $this->path;
        }

        throw new FileNotFoundException("File does not exist at path {$path}");
    }

    /**
     * Set stub path.
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get base path.
     *
     * @return string|null
     */
    public static function getBasePath()
    {
        return static::$basePath;
    }

    /**
     * Set base path.
     *
     * @param string $path
     */
    public static function setBasePath($path)
    {
        static::$basePath = $path;
    }

    /**
     * Create a directory.
     *
     * @param  string $path
     * @param  int $mode
     * @param  bool $recursive
     * @param  bool $force
     * @return bool
     */
    public function makeDirectory($path, $mode = 0755, $recursive = false, $force = false)
    {
        if ($force) {
            return @mkdir($path, $mode, $recursive);
        }

        return mkdir($path, $mode, $recursive);
    }

    /**
     * Set default stub folder path
     *
     * @param $path
     *
     * @return string
     */
    public function setDefaultPath($path)
    {
        $this->defaultStubFolderPath = $path;
    }

    /**
     * Set replacements array.
     *
     * @param array $replaces
     *
     * @return $this
     */
    public function replace(array $replaces = [])
    {
        $this->replaces = $replaces;

        return $this;
    }

    /**
     * Get replacements.
     *
     * @return array
     */
    public function getReplaces()
    {
        return $this->replaces;
    }

    /**
     * Handle magic method __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Get stub contents.
     *
     * @return string
     */
    public function render()
    {
        return $this->getContents();
    }
}