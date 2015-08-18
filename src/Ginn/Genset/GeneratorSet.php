<?php

namespace Ginn\Genset;

use Symfony\Component\Filesystem\Filesystem;
use Psr\Log\LoggerInterface;
use \Twig_Loader_Filesystem;
use \Twig_Environment;

class GeneratorSet
{
    private $filesystem;
    private $logger;

    public function __construct(Filesystem $filesystem, LoggerInterface $logger)
    {
        $this->filesystem = $filesystem;
        $this->logger = $logger;
    }

    public function create($name, $path)
    {
        $name = strtolower($name);
        $path = rtrim(strtolower($path), '/').'/';

        $loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
        $twig = new Twig_Environment($loader, array(
            'cache' => __DIR__.'/cache',
        ));

        $this->filesystem->dumpFile(
                $path.'controllers/'.ucfirst($name).'.php',
                $twig->render('controller.twig', array('name' => $name))
            );
        $this->filesystem->dumpFile(
                $path."models/Model_$name.php",
                $twig->render('model.twig', array('name' => $name))
            );
        $this->filesystem->dumpFile(
                $path."views/$name/index.php",
                $twig->render('view-index.twig', array('name' => $name))
            );
        $this->filesystem->dumpFile(
                $path."views/$name/form.php",
                $twig->render('view-form.twig', array('name' => $name))
            );
        $this->filesystem->dumpFile(
                $path."views/$name/single.php",
                $twig->render('view-single.twig', array('name' => $name))
            );

        $this->logger->notice(sprintf('Created file %s', $path.'controllers/'.ucfirst($name).'.php'));
        $this->logger->notice(sprintf('Created file %s', $path."models/Model_$name.php"));
        $this->logger->notice(sprintf('Created file %s', $path."views/$name/index.php"));
        $this->logger->notice(sprintf('Created file %s', $path."views/$name/form.php"));
        $this->logger->notice(sprintf('Created file %s', $path."views/$name/single.php"));
    }
}
