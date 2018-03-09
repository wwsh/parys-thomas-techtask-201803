<?php

namespace TechTask\Database;

/**
 * Main database component.
 *
 * @package TechTask\Database
 */
class DatabaseFacade implements DatabaseInterface
{
    /** @var DataLoader */
    protected $loader;

    /** @var DataProcessor */
    protected $processor;

    /** @var ModelMapper */
    protected $mapper;

    /** @var string */
    protected $resourceToLoad;

    /**
     * @param DataLoader $dataLoader
     * @param string $resourceToLoad
     * @param DataProcessor $dataProcessor
     * @param ModelMapper $modelMapper
     */
    public function __construct(
        DataLoader $dataLoader,
        string $resourceToLoad,
        DataProcessor $dataProcessor,
        ModelMapper $modelMapper
    ) {
        $this->loader = $dataLoader;
        $this->resourceToLoad = $resourceToLoad;
        $this->processor = $dataProcessor;
        $this->mapper = $modelMapper;
    }

    /**
     * @return array|object[]
     */
    public function findAll()
    {
        $data = $this->loader->load($this->resourceToLoad);
        $data = $this->processor->process($data);
        $data = $this->mapper->map($data);

        return $data;
    }
}
